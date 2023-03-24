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
                      Liste des demandes de retrait sur visa
                      </h2>
                    </div>
                    
                    <div class="body table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                  <th style="text-align: center;"> Numéro</th>
                                  <th style="text-align: center;"> Identifiant</th>
                                  <th style="text-align: center;"> Montant</th>
                                  <th style="text-align: center;"> Intitulé de la carte</th>
                                  <th style="text-align: center;"> Nom et prénom</th>
                                  <th style="text-align: center;"> Identifiant de la carte</th>
                                  <th style="text-align: center;"> Date de la demande</th>
                                  <th style="text-align: center;"> Date de service </th>
                                  <th style="text-align: center;"> Actions [ Echec; Servir; Statut; Supprimer ]</th>
                                  
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($visas as $visa)
                              <tr>
                                <td style="text-align: center;">{{ $visa->id }}</td>
                                <td style="text-align: center;">{{ $visa->codeperso }}</td>
                                
                                <td style="text-align: center;" >{{ $visa->mont }}</td>
                                <td style="text-align: center;">{{ $visa->intitule }}</td>
                                <td style="text-align: center;">{{ $visa->nom }}</td>
                                <td style="text-align: center;">{{ $visa->idcarte }}</td>
                                
                                <td style="text-align: center;">{{ $visa->created_at }}</td>
                                <td style="text-align: center;">
                                    @if (strtotime($visa->created_at) != strtotime($visa->updated_at))
                                        {{ $visa->updated_at }}
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                  @if($visa->statut == 1)
                                      <button type="button" title="Echec" class="btn btn-warning btn-circle btn-xs  margin-bottom-10 waves-effect waves-light"><a href="{{ route('Visaechec', $visa->id) }}" style="color:white;"> 
                                      <i class="material-icons">assignment</i></a></button>
                                  @else
                                      <button type="button" title="Echec" class="btn btn-circle btn-xs  margin-bottom-10 waves-effect waves-light"><a href="#" style="color:white;"> <i class="material-icons">assignment</i></a></button>
                                  @endif

                                  @if($visa->statut == 1)
                                      <button type="button" title="Servir" class="btn btn-primary btn-circle btn-xs  margin-bottom-10 waves-effect waves-light"><a href="{{ route('Visaservir', $visa->id) }}" style="color:white;"> 
                                      <i class="material-icons">assignment</i></a></button>
                                  @else
                                      <button type="button" title="Servir" class="btn btn-circle btn-xs  margin-bottom-10 waves-effect waves-light"><a href="#" style="color:white;"> <i class="material-icons">assignment</i></a></button>
                                  @endif

                                  @if($visa->statut == 0)
                                      <button type="button" title="Statut" class="btn  btn-circle btn-xs  margin-bottom-10 waves-effect waves-light" style=" background-color: #a2bd40"><a href="#" style="color:white;"> 
                                      <i class="material-icons">event_available</i></a></button>
                                  @else
                                      <button type="button" title="Statut" class="btn btn-circle btn-xs  margin-bottom-10 waves-effect waves-light" style=" background-color: #ccc2c2"><a href="#" style="color:white;"> 
                                      <i class="material-icons" >event_busy</i></a></button>
                                  @endif

                                  <button type="button" title="Supprimer"  class="btn btn-danger btn-circle btn-xs  margin-bottom-10 waves-effect waves-light"><a href="{{ route('Visadelete',$visa->id)}}" style="color:white;"><i class="material-icons">delete_sweep</i></a> </button>

                                </td>
                              
                              </tr>
                            @empty
                              <tr >
                                <td colspan="12" style="text-align: center;">Pas de demande disponible!!!</td>
                              </tr>
                            @endforelse
                            </tbody>
                        </table>
                        {{ $visas->links() }}
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Hover Rows -->

    </div>
</section>

@endsection