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
                                  <th style="text-align: center;"> Statut</th>
                                  <th style="text-align: center;"> Date de la demande</th>
                                  <th style="text-align: center;"> Date de service </th>
                                  <th style="text-align: center;"> Envoyer une erreur</th>
                                  <th style="text-align: center;"> Servir</th>
                                  <th style="text-align: center;"> Supprimer</th>
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
                                <td style="text-align: center;">
                                    @if($achat->statut == 1)
                                      <p style="color:red">En cours</p>
                                    @else
                                      <p style="color:green">Valider</p>
                                    @endif
                                </td>
                                <td style="text-align: center;">{{ $achat->created_at }}</td>
                                <td style="text-align: center;">
                                    @if (strtotime($achat->created_at) != strtotime($achat->updated_at))
                                        {{ $achat->updated_at }}
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if($achat->statut == 1)
                                      <a href="{{ route('achatechec', $achat->id) }}"><i class="material-icons" style="color: red;">done</i></a>
                                    @else
                                      <a href="#"><i class="material-icons" style="color: #A6ACAF;">done</i></a>
                                    @endif
                                    
                                </td>
                                <td style="text-align: center;">
                                    @if($achat->statut == 1)
                                      <a href="{{ route('achatservir', $achat->id) }}"><i class="material-icons" style="color: green;">done</i></a>
                                    @else
                                      <a href="#"><i class="material-icons" style="color: #A6ACAF;">done</i></a>
                                    @endif
                                    
                                </td>
                                <td style="text-align: center;">
                                    
                                      <a href="{{ route('deleteachat', $achat->id) }}"><i class="material-icons" style="color: #ffa500;">done</i></a>
                                  
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