@extends('layouts.templaterefonte')

@section('content')
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta charset="UTF-8">
  <div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <div class="main-body">
                                <div class="page-wrapper">

                                    <div class="page-body">
                                      <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5>Mes filleuls clients ({{ count($users) }})</h5>
                                                        <div class="card-header-right">
                                                            <ul class="list-unstyled card-option">
                                                                <li><i class="fa fa-chevron-left"></i></li>
                                                                <li><i class="fa fa-window-maximize full-card"></i></li>
                                                                <li><i class="fa fa-minus minimize-card"></i></li>
                                                                <li><i class="fa fa-refresh reload-card"></i></li>
                                                                <li><i class="fa fa-times close-card"></i></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="card-block">
                                                        <!-- Tab panes -->
                                                        <div class="tab-content card-block">
                                                            <div class="tab-pane active" role="tabpanel">

                                                                <div class="table-responsive">
                                                                    <table class="table">
                                                                        <tr>
                                                                            <th>Image</th>
                                                                            <th>Nom & Prenom Filleul</th>
                                                                            <th>Parrainnage</th>
                                                                            <th>Identifiant</th>
                                                                            <th>Status</th>
                                                                            <th>Parrain</th>
                                                                            <th>Categorie</th>
                                                                            <th>Inscrire le</th> 
                                                                        </tr>
                                                                        @forelse($users as $filleul)
                
                                                                          <tr style="text-align: center;">
                                                                            <td><img class="img-radius" style="height: 30px; width: 30px" src="newrefonte/assets/images/defaut.png" alt="prod img" class="img-fluid"></td>
                                                                            <td>{{ $filleul->nom }} {{ $filleul->prenom }}</td>
                                                                            
                                                                            <td>{{ $filleul->codeunique }}</td>
                                                                            <td>{{ $filleul->codeperso}}</td>
                                                                            <td>
                                                                              @if($filleul->compteactive == "oui")
                                                                                  <span class="label label-success">Actif</span>
                                                                              @endif
                                                                              @if($filleul->compteactive == "non")
                                                                                  <span class="label label-danger">Inactif</span> 
                                                                              @endif
                                                                            </td>
                                                                            <td>{{ $filleul->parrain }}</td>
                                                                            <td>
                                                                                @if($filleul->Pack == 2)
                                                                                    <span class="label" style="background-color: #FFD5C0">Vendeur</span>
                                                                                @endif
                                                                                @if($filleul->Pack == 1)
                                                                                    <span class="label" style="background-color: #BD9CF1">Client</span>
                                                                                @endif
                                                                            </td>
                                                                            <td>{{ $filleul->created_at}}</td>
                                                                          </tr>
                                                                        @empty
                                                                          <tr >
                                                                            <td colspan="6" style="text-align: center;">Pas de Filleul disponible!!!</td>
                                                                          </tr>
                                                                        @endforelse
                                                                    </table>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

@endsection
