@extends('layouts.templaterefonte')

@section('content')

<div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <div class="main-body">
                                <div class="page-wrapper">

                                    <div class="page-body">
                                      <div class="row">

                                            <div class="col-md-12 col-lg-4">
                                                <div class="card">
                                                    <div class="card-block text-center">
                                                        <i class="ti-reload text-c-blue d-block f-40"></i>
                                                        <h4 class="m-t-20"><span class="text-c-blue">
                                                          @if(isset($gains[0]->gainvirtuel)) 
                                                            {{ $gains[0]->gainvirtuel }}  
                                                          @else
                                                            0 
                                                          @endif
                                                        </span> $ SSI</h4>
                                                        <p class="m-b-20">Gain Virtuel</p>
                                                        <button class="btn btn-primary btn-sm btn-round">G V</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-4">
                                                <div class="card">
                                                    <div class="card-block text-center">
                                                        <i class="ti-reload text-c-green d-block f-40"></i>
                                                        <h4 class="m-t-20"><span class="text-c-blgreenue">
                                                          @if(isset($gains[0]->gainespece)) 
                                                          {{ $gains[0]->gainespece }}  
                                                          @else
                                                              0 
                                                          @endif
                                                        </span> $ SSI</h4>
                                                        <p class="m-b-20">Gain en Espèce</p>
                                                        <button class="btn btn-success btn-sm btn-round">G E</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-4">
                                                <div class="card">
                                                    <div class="card-block text-center">
                                                        <i class="ti-reload text-c-pink d-block f-40"></i>
                                                        <h4 class="m-t-20"><span class="text-c-blgreenue">
                                                          @if(isset($gains[0]->gaincommissionvente)) 
                                                          {{ $gains[0]->gaincommissionvente }}  
                                                          @else
                                                              0 
                                                          @endif
                                                        </span> $ SSI</h4>
                                                        <p class="m-b-20">Commission sur Vente</p>
                                                        <button class="btn btn-danger btn-sm btn-round">C V</button>
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