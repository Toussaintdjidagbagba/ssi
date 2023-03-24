@extends('layouts.templaterefonteadmin')

@section('content')


<section class="content">
    <div class="container-fluid">
        <!-- Hover Rows -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                      <h2>
                      Liste des demandes d'achat de gain
                      </h2>
                    </div>
                     
                    <div class="body table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                  <th style="text-align: center;"> Id</th>
                                  <th style="text-align: center;"> Identifiant</th>
                                  <th style="text-align: center;"> Libellé compte</th>
                                  <th style="text-align: center;"> Montant</th>
                                  <th style="text-align: center;"> Référence</th>
                                  <th style="text-align: center;"> Date de la demande</th>
                                  <th style="text-align: center;"> Date de service </th>
                                  <th style="text-align: center;"> Actions [ Echec; Servir; Statut; Supprimer ]</th>
                                  
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($achats as $achat)
                              <tr>
                                <td style="text-align: center;">{{ $achat->id }}</td>
                                <td style="text-align: center;">{{ $achat->codeperso }}</td>
                                <td style="text-align: center;">
                                  @if( $achat->libellecompte==1)
                                  Compte espèce
                                  @endif
                                  @if( $achat->libellecompte==2)
                                  Compte virtuel
                                  @endif
                                </td>
                                
                                <td style="text-align: center;" >{{ $achat->montant }}</td>
                                <td style="text-align: center;">{{ $achat->referencepaye }}</td>
                                
                                <td style="text-align: center;">{{ $achat->created_at }}</td>
                                <td style="text-align: center;">
                                    @if (strtotime($achat->created_at) != strtotime($achat->updated_at))
                                        {{ $achat->updated_at }}
                                    @endif
                                </td>
                                
                                <td style="text-align: center;">

                                  @if($achat->statut == 1)
                                      <button type="button" title="Echec" class="btn btn-warning btn-circle btn-xs  margin-bottom-10 waves-effect waves-light"><a href="{{ route('achatechec', $achat->id) }}" style="color:white;"> 
                                      <i class="material-icons">assignment</i></a></button>
                                  @else
                                      <button type="button" title="Echec" class="btn btn-circle btn-xs  margin-bottom-10 waves-effect waves-light"><a href="#" style="color:white;"> <i class="material-icons">assignment</i></a></button>
                                  @endif

                                  @if($achat->statut == 1)
                                      <button type="button" title="Servir" class="btn btn-primary btn-circle btn-xs  margin-bottom-10 waves-effect waves-light"><a href="{{ route('achatservir', $achat->id) }}" style="color:white;">
                                           <i class="material-icons">assignment</i></a></button>
                                  @else
                                      <button type="button" title="Servir" class="btn btn-circle btn-xs  margin-bottom-10 waves-effect waves-light"><a href="#" style="color:white;"> <i class="material-icons">assignment</i></a></button>
                                  @endif

                                  @if($achat->statut == 0)
                                      <button type="button" title="Statut" class="btn  btn-circle btn-xs  margin-bottom-10 waves-effect waves-light" style=" background-color: #a2bd40"><a href="#" style="color:white;"> 
                                      <i class="material-icons">event_available</i></a></button>
                                  @else
                                      <button type="button" title="Statut" class="btn btn-circle btn-xs  margin-bottom-10 waves-effect waves-light" style=" background-color: #ccc2c2"><a href="#" style="color:white;"> 
                                      <i class="material-icons" >event_busy</i></a></button>
                                  @endif


                                  <button type="button" title="Supprimer"  class="btn btn-danger btn-circle btn-xs  margin-bottom-10 waves-effect waves-light"><a href="{{ route('deleteachat',$achat->id)}}" style="color:white;"><i class="material-icons">delete_sweep</i></a> </button>
                                     
                                </td>
                              </tr>
                            @empty
                              <tr >
                                <td colspan="10" style="text-align: center;">Pas de demande disponible!!!</td>
                              </tr>
                            @endforelse
                            </tbody>
                        </table>
                        {{ $achats->links() }}
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Hover Rows -->

    </div>
</section>

@endsection