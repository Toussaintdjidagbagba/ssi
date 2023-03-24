@extends('layouts.templaterefonteadmin')

@section('css')
<style>

	#libelle{
		width:450px;
		padding-right:-40px;
		height: 100px ; 
		overflow:auto;
		white-space:pre-line; text-overflow: ellipsis;
		word-wrap: break-word;
	}

</style>
@endsection

@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
                @include('flash::message')
                <h2>
                    ( Historique à partir du 26 Août 2021 à 15h )
                    <small></small> 
                </h2>
            </div>
      <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card"> 
                <div class="header">
                    <h2 style="margin-right: 30px; float: right; padding-right: 30px; padding-left: 30px;">
                    Historique des translations client
                    </h2>
                    <form  class="form-inline" method="get" id="recherche" action="{{ route('histadminclient') }}">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                      <input class=" form-control" type="hidden" name="rec" value="1">
                      <input class="form-control mr-sm-2" type="search" placeholder="identifiant" name="check" id="search" aria-label="Search">
                      <button class="btn btn-outline-info my-2 my-sm-0" type="submit" id="sub" style="background-color: blue; color: white"> <i class="material-icons">search</i></button>
                    </form>
                    <script>      
                    var y = document.getElementById("recherche");
                    y.addEventListener("blur", function () {
                      const input = document.getElementById("sub")
                            input.click()
                    }, true);   
                    </script>
                </div>
                <div class="body">
                    <div class="table-responsive" data-pattern="priority-columns">
                                <table id="tech-companies-1" class="table table-small-font table-bordered table-striped">
                            <thead>
                                <tr>
                                  <th > Identifiant </th>
                                  <th > Libellé de la translation </th>
                                  <th > Date de l'opération</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($hists as $hist)
                              <tr style="text-align: center">
                                <td title="{{ $hist->nom }} {{ $hist->prenom }}"> {{ $hist->codeperso }} </td>
                                <td > {{ $hist->libelle }} </td>
                                <td >  {{ $hist->created_at}}</td>
                              </tr>
                            @empty
                              <tr >
                                <td colspan="3" style="text-align: center; color: red">Historique vide!</td>
                              </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    </div> 
                </div>
            </div>
        </div>
      </div>       

    </div>
</section>          
                
@endsection