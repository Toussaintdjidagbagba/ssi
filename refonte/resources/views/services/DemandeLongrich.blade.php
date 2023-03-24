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
                      Liste des demandes d'inscription Longrich
                      </h2>
                    </div>
                    <div class="text-center">
                          @include('flash::message')
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                  <th><i class="icon_ol"></i> Référence No </th> 
                                  <th><i class="icon_pin_alt"></i> Pseudo </th>
                                  <th><i class="icon_pin_alt"></i> Nom & Prénom </th>
                                  <th><i class="icon_pin_alt"></i> Mail / Téléphone</th>
                                  <th><i class="icon_pin_alt"></i> Date / Pays </th>
                                  <th><i class="icon_pin_alt"></i> Montant Payer</th>
                                  <th><i class="icon_pin_alt"></i> Envoyer le </th>
                                  <th><i class="icon_pin_alt"></i> Délivré recu</th>
                                  <th><i class="icon_pin_alt"></i> Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($demandes as $demande)
                              <tr>
                                <td>{{ $demande->RefRecu }}</td>
                                <td>{{ $demande->pseudo }}</td>
                                <td>{{ $demande->Nom }} {{ $demande->Prenom }}</td>
                                <td>{{ $demande->Email }} / {{ $demande->Tel }}</td>
                                <td>{{ $demande->dateL }} <br> {{ $demande->pays }} </td>
                                <td>{{ $demande->MontantPayer }}</td>
                                <td>{{ $demande->date }}</td>
                                <td> <a href="/longrich-recu:reference-{{ $demande->RefRecu }}"><i class="material-icons">done</i></a> </td>
                                <td>
                                  @if($demande->Statut == "oui")
                                      <i style="color: white; background-color: green;" class="material-icons">check_box</i>
                                  @else
                                      <i style="color: white; background-color: red;" class="material-icons">check_box</i>
                                  @endif
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
        <!-- #END# Hover Rows -->

    </div>
</section>

@endsection