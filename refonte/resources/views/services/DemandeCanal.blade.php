@extends('layouts.template_admin')

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
                                  <th> Référence No </th> 
                                  <th> Nom & Prénom </th>
                                  <th> Mail / WhatsApp </th>
                                  <th> Numéro Police du compteur</th>
                                  <th> Présentation </th>
                                  <th> Montant Facture</th>
                                  <th> Envoyer le </th>
                                  <th> Délivré recu</th>
                                  <th> Statut</th>
                                  <th> Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($demandes as $demande)
                              <tr>
                                <td>{{ $demande->RefRecu }}</td>
                                <td>{{ $demande->Nom }} {{ $demande->Prenom }}</td>
                                <td>{{ $demande->EmailUser }} / {{ $demande->TelUser }}</td>
                                <td> {{ $demande->Choisirformule }} <br> {{ $demande->Dureenmois }} mois</td>
                                <td> {{ $demande->Numerocarte }} </td>
                                <td>{{ $demande->MontantPayer }}</td>
                                <td>{{ $demande->date }}</td>
                                <td> <a href="/canal-recu:reference-{{ $demande->RefRecu }}"><i class="material-icons">done</i></a> </td>
                                <td>
                                  @if($demande->Statut == "oui")
                                      <i style="color: white; background-color: green;" class="material-icons">check_box</i>
                                  @else
                                      <i style="color: white; background-color: red;" class="material-icons">check_box</i>
                                  @endif
                                </td>    
                                <td>
                                  <a class="" 
                                        style="color:red;font-weight:bold;" 
                                        href="{{url('admin/delete-canals-'.$demande->RefRecu)}}">
                                        <i class="material-icons">delete</i> </a> 
                                </td> 
                              </tr>
                            @empty
                              <tr >
                                <td colspan="8" style="text-align: center;">Pas de demande disponible!!!</td>
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