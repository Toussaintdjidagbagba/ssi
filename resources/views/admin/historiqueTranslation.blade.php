@extends('layouts.templaterefonteadmin')

@section('css')
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
                @include('flash::message')
                <h2>
                    ( Historique à partir du 23 Août 2021 à 14h44min19s )
                    <small></small> 
                </h2>
            </div>
      <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card"> 
                <div class="header">
                    <h2>
                    Historique des translations
                    </h2>
                </div>
                <div class="body"> 
                    <div class="table-responsive" data-pattern="priority-columns">
                            <table id="tech-companies-1" class="table table-small-font table-bordered table-striped">
                            <thead>
                                <tr>
                                  <th > Libelle de la translation</th>
                                  <th > Contenu </th>
                                  <th > Date </th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($hists as $hist)
                              <tr style="text-align: center">
                                <td>
                                      @switch($hist->code)
                                          @case('A')
                                              Transfert d'un compte à l'autre
                                              @break
                                          @case('B')
                                              Prélever du compte client
                                              @break
                                          @case('C')
                                              Transfert sur le compte commission sur vente du client
                                              @break
                                          @case('D')
                                              Prélever du compte commission sur vente du client
                                              @break
                                          @case('E')
                                              Transfert sur le compte virtuel du client
                                              @break
                                          @case('F')
                                              Prélever du compte virtuel du client
                                              @break
                                          
                                          @default
                                              Inconnu
                                      @endswitch
                                      
                                </td>
                                <td> {{ $hist->libelle }}</td>
                                <td> {{ $hist->created_at}}</td>
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
</section>    

@endsection