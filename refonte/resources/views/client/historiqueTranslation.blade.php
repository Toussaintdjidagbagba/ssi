@extends('layouts.templaterefonte')

@section('content')
<div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <div class="main-body">
                                <div class="page-wrapper">

                                    <div class="page-body">
                                      <div class="row"> 
                                        <div class="col-lg-12">
                                          ({{ utf8_encode(" Historique à partir du 26 Août 2021 à 15h")}} )
                                         
                                          
          

                                            <div class="col-lg-12 col-md-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5>Historique des translations</h5>
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
                                                                            <th>{{ utf8_encode("Libellé de la translation")}}</th>
                                                                            <th>{{ utf8_encode("Date de l'opération")}}</th>
                                                                            
                                                                        </tr>
                                                                        @forelse($hists as $hist)
                                                                          <tr style="text-align: center">
                                                                            
                                                                            <td > {{ $hist->libelle }}</td>
                                                                            <td > {{ $hist->created_at}}</td>
                                                                          </tr>
                                                                        @empty
                                                                          <tr >
                                                                            <td colspan="2" style="text-align: center; color: red">Historique vide!</td>
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