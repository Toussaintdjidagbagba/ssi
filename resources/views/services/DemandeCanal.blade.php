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
                      Liste des demandes d'abonnement canal+
                      </h2>
                    </div>
                    <div class="text-center">
                          @include('flash::message')
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                  <th>Identifiant </th> 
                                  <th> Nom & Prénom </th>
                                  <th> Mail / WhatsApp </th>
                                  <th> Numéro Police du compteur</th>
                                  <th> Présentation </th>
                                  <th> Montant Facture</th>
                                  <th> Envoyer le </th>
                                  <th> Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($demandes as $demande)
                              <tr>
                                <td>{{ $demande->CodePersoUser }}</td>
                                <td>{{ $demande->Nom }} {{ $demande->Prenom }}</td>
                                <td>{{ $demande->EmailUser }} / {{ $demande->TelUser }}</td>
                                <td> {{ $demande->Choisirformule }} <br> {{ $demande->Dureenmois }} mois</td>
                                <td> {{ $demande->Numerocarte }} </td>
                                <td>{{ $demande->MontantPayer }}</td>
                                <td>{{ $demande->date }}</td>
                                <td>
                                  <button type="button" title="Reçu"  class="btn btn-primary btn-circle btn-xs  margin-bottom-10 waves-effect waves-light">
                                    <a href="{{ route('canalrecu', $demande->RefRecu)}}" style="color:white;"> <i class="material-icons">assignment</i></a> 
                                  </button>
                                  @if($demande->Statut == "oui")
                                      <button type="button" title="Statut" class="btn  btn-circle btn-xs  margin-bottom-10 waves-effect waves-light" style=" background-color: #a2bd40"><a href="#" style="color:white;"> 
                                      <i class="material-icons">event_available</i></a></button>
                                  @else
                                      <button type="button" title="Statut" class="btn  btn-circle btn-xs  margin-bottom-10 waves-effect waves-light" style=" background-color: #ccc2c2"><a href="#" style="color:white;"> 
                                      <i class="material-icons">event_busy</i></a></button>
                                  @endif

                                  <button type="button" title="Supprimer"  class="btn btn-danger btn-circle btn-xs  margin-bottom-10 waves-effect waves-light"><a href="{{ route('deleteCa',$demande->RefRecu)}}" style="color:white;"><i class="material-icons">delete_sweep</i></a> </button>

                                </td>
                              </tr>
                            @empty
                              <tr >
                                <td colspan="6" style="text-align: center;">Pas de demande disponible!!!</td>
                              </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Hover Rows -->

    </div>
</section>
@endsection