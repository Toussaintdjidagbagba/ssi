@extends('layouts.templaterefonte')

@section('content')

  <div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <div class="main-body">
                                <div class="page-wrapper">

                                    <div class="page-body">
                                      <div class="row">

                                            <!-- order-card start -->
                                            <div class="col-md-6 col-xl-3">
                                                <div class="card bg-c-blue order-card">
                                                    <div class="card-block">
                                                        <h6 class="m-b-20">Gain Virtuel</h6>
                                                        <h2 class="text-right"><i class="ti-reload f-left"></i><span>
                                                          @if(isset($gains[0]->gainvirtuel)) 
                                                            {{ $gains[0]->gainvirtuel }} $ SSI
                                                          @else
                                                            0 $ SSI
                                                          @endif
                                                        </span></h2>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3">
                                                <div class="card bg-c-green order-card">
                                                    <div class="card-block">
                                                        <h6 class="m-b-20">Gain en Espèce</h6>
                                                        <h2 class="text-right"><i class="ti-reload f-left"></i><span>
                                                          @if(isset($gains[0]->gainespece)) 
                                                          {{ $gains[0]->gainespece }} $ SSI
                                                          @else
                                                              0 $ SSI
                                                          @endif
                                                        </span></h2>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3">
                                                <div class="card bg-c-yellow order-card">
                                                    <div class="card-block">
                                                        <h6 class="m-b-20">Commission sur vente</h6>
                                                        <h2 class="text-right"><i class="ti-reload f-left"></i><span>
                                                          @if(isset($gains[0]->gaincommissionvente)) 
                                                          {{ $gains[0]->gaincommissionvente}} $ SSI
                                                          @else
                                                              0 $ SSI
                                                          @endif
                                                        </span></h2>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3">
                                                <div class="card order-card" style="background-color: #58bde7">
                                                    <div class="card-block">
                                                        <h6 class="m-b-20">Etape</h6>
                                                        <h2 class="text-right"><i class="ti-wallet f-left"></i><span>{{ $etape }}</span></h2>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- order-card end -->

                                            <!-- statustic and process start -->
                                            <div class="col-lg-12 col-md-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5>Mes filleuls</h5>
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
                                                                            <th>Nom & Prénom Filleul</th>
                                                                            <th>Parrainnage</th>
                                                                            <th>Identifiant</th>
                                                                            <th>Status</th>
                                                                            <th>Parrain</th>
                                                                            <th>Inscrire le</th> 
                                                                        </tr>
                                                                        @forelse($filleuls as $filleul)
                
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
