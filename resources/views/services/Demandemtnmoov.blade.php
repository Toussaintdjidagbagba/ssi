@extends('layouts.templaterefonteadmin')

@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
                @include('flash::message')
                <h2>
                    
                    <small></small> 
                </h2>
            </div>
      <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card"> 
                <div class="header">
                    <h2>
                    Liste des demandes MTN / MOOV
                    
                </div>
                
                <div class="body">
                    <div class="table-responsive" data-pattern="priority-columns">
                        <table id="tech-companies-1" class="table table-small-font table-bordered table-striped">
                            <thead>
                                <tr>
                                  <th> Nom</th>
                                  <th> Identifiant</th>
                                  <th> Téléphone</th>
                                  <th> Libelle</th>
                                  <th> Description</th>
                                  <th> Fichier</th>
                                  <th> Envoyer le</th>
                                  <th> Montant Payer</th>
                                  <th> Valider le</th>
                                  <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($demandes as $monetique)
                              <tr>
                                <td>{{ $monetique->NomUser }}</td>
                                <td>{{ $monetique->CodePersoUser }}</td>
                                <td>{{ $monetique->Tel }}</td>
                                <td>{{ $monetique->libelle }}</td>
                                <td>{{ $monetique->description }}</td>
                                <td><a href="{{ $monetique->fichie }}"> {{ $monetique->fichie }} </a></td>
                                <td>{{ $monetique->created_at }}</td>
                                <td>{{ $monetique->MontantPayer }}</td>
                                <td>{{ $monetique->DateValider }}</td>
                                
                                
                                <td>

                                  @if($monetique->Statut == "oui")
                                      <button type="button" title="Reçu" class="btn btn-circle btn-xs  margin-bottom-10 waves-effect waves-light"><a href="#" style="color:white;"> 
                                      <i class="material-icons ">assignment</i></a></button>
                                  @else
                                      <button type="button" title="Reçu" class="btn btn-primary btn-circle btn-xs  margin-bottom-10 waves-effect waves-light">
                                          <a href="{{ route('mtnmoovrecuS', $monetique->id)}}" style="color:white;"> <i class="material-icons">assignment</i></a></button>
                                  @endif

                                  @if($monetique->Statut == "oui")
                                      <button type="button" title="Statut" class="btn btn-circle btn-xs  margin-bottom-10 waves-effect waves-light" style=" background-color: #a2bd40"><a href="#" style="color:white;"> <i class="material-icons">event_available</i></a></button>
                                  @else
                                      <button type="button" title="Statut" class="btn btn-circle btn-xs  margin-bottom-10 waves-effect waves-light" style=" background-color: #ccc2c2"><a href="#" style="color:white;"> <i class="material-icons">event_busy</i></a></button>
                                  @endif


                                  <button type="button" title="Supprimer"  class="btn btn-danger btn-circle btn-xs  margin-bottom-10 waves-effect waves-light"><a href="{{ route('deleteS',$monetique->id)}}" style="color:white;"><i class="material-icons">delete_sweep</i></a> </button>

                                </td>
                                
                                
                              </tr>
                            @empty
                              <tr >
                                <td colspan="9" style="text-align: center;">Pas de demande disponible!!!</td>
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