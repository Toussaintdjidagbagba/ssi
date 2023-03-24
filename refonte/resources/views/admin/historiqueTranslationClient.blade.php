@extends('layouts.template_admin')

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


        <div class="row">
          
          <div class="col-lg-12">
            ( Historique à partir du 26 Août 2021 à 15h )
            <div class="text-center">
                    @include('flash::message')
                  </div>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i></li>
              <li style="text-align: right"> <a href="{{ route('histadminclient') }}">Historique des translations client</a> </li>
            </ol>
          </div>
          
        </div>
        <div class="col-lg-7">
            
        </div>
        <div class="col-lg-3">
            
            <form class="form-inline" method="get" id="recherche" action="{{ route('histadminclient') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input class=" form-control" type="hidden" name="rec" value="1">
              <input class="form-control mr-sm-2" type="search" placeholder="identifiant" name="check" id="search" aria-label="Search">
              
        </div>
        <div class="col-lg-2">
            <button class="btn btn-outline-info my-2 my-sm-0" type="submit" id="sub" style="background-color: blue; color: white"> <i class="material-icons">search</i></button>
            </form>
            <br> <br>
        </div>
        <script>			
        var y = document.getElementById("recherche");
        y.addEventListener("blur", function () {
          const input = document.getElementById("sub")
                input.click()
        }, true);		
        </script>

        <!-- Hover Rows -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                      <h2>
                      </h2>
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                  <th style="text-align: center; background-color: #458b00; color: white"> Identifiant </th>
                                  <th style="text-align: center; background-color: #458b00; color: white"> Libellé de la translation </th>
                                  <th style="text-align: center; background-color: #458b00; color: white"> Date de l'opération</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($hists as $hist)
                              <tr style="text-align: center">
                                <td title="{{ $hist->nom }} {{ $hist->prenom }}"> {{ $hist->codeperso }} </td>
                                <td ><p id="libelle" style=""> {{ $hist->libelle }} </p> </td>
                                <td >  {{ $hist->created_at}}</td>
                              </tr>
                            @empty
                              <tr >
                                <td colspan="3" style="text-align: center; color: red">Historique vide!</td>
                              </tr>
                            @endforelse
                            </tbody>
                        </table>
                        {{$hists->links()}}
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Hover Rows -->

    </div>
</section>


@endsection