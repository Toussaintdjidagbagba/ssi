@extends('layouts.template_admin')

@section('css')


  <style type="text/css">
    .carre{
      width: 200px;
      height: 200px;
      text-align: center;
      color: white;
    }

    .arrondi{
      border-radius: 50%;
      line-height: 100px;
      
    }
  </style>
  
@endsection

@section('content')

<section class="content">
    <div class="container-fluid">
        <!-- Hover Rows -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                      <h2>
                      Liste des demandes de retraire sur mobile money MTN
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
                                  <th> Motif </th>
                                  <th> Numéro </th>
                                  <th> Montant </th>
                                  <th>Identifiant <br> Filleul</th>
                                  <th> Envoyer le</th>
                                  <th> Délivré recu</th>
                                  <th> Délivré le</th>
                                  <th> Statut</th>
                                  <th> Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($demandes as $demande)
                              <tr>
                                <td>{{ $demande->reff }}</td>
                                <td>{{ $demande->intitule }}</td>
                                <td>{{ $demande->numero }}</td>
                                <td> {{ $demande->montant }} $ SSI</td>
                                <td> {{ $demande->codeperso }} </td>
                                <td>{{ $demande->created_at }}</td>
                        
                                <td> <a href="/mtn-recu:reference-{{ $demande->reff }}">Etablir recu</a> </td>
                                <td>{{ $demande->datevalider }}</td>
                                <td>
                                  @if($demande->statut == "oui")
                                      <i style="color: white; background-color: green">recu envoyée</i>
                                  @else
                                      <i style="color: white; background-color: red">en attente</i> 
                                  @endif
                                </td>
                                <td> 
                                  <a class="" 
                                        style="color:red;font-weight:bold;" 
                                        href="{{url('admin/delete-demanderetraitmtn-'.$demande->reff)}}">
                                    Supprimer 
                                  </a>
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