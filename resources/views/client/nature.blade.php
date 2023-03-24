@extends('layouts.templaterefonte')

@section('content')

<div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <div class="main-body">
                                <div class="page-wrapper">

                                    <div class="page-body">
                                      <div class="row">
                                        <div class="col-lg-12">
                                          <h3 class="page-header">Nature</h3>
                                        </div>

                                        <div class="col-md-12 col-lg-4">
                                                <div class="card">
                                                    <div class="card-block text-center">
                                                        <img src="/TEST/nature/1/etape.png"  id="signataire">
                                                        <h4 class="m-t-20"><span class="text-c-blue">
                                                          
                                                        </span> ETAPE 1</h4>
                                                        <p class="m-b-20">Tee shirt SSI + KIT de demarrage (12$ SSI) </p>
                                                        <button class="btn btn-primary btn-sm btn-round"> {{ App\Providers\InterfaceServiceProvider::valPV(1) }} PV</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-lg-4">
                                                <div class="card">
                                                    <div class="card-block text-center">
                                                        <img src="/TEST/nature/2/etape.png"  id="signataire">
                                                        <h4 class="m-t-20"><span class="text-c-blue">
                                                          
                                                        </span> ETAPE 2</h4>
                                                        <p class="m-b-20">Kit alimentaire 1 (15$ SSI) </p>
                                                        <button class="btn btn-primary btn-sm btn-round">{{ App\Providers\InterfaceServiceProvider::valPV(2) }} PV</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-lg-4">
                                                <div class="card">
                                                    <div class="card-block text-center">
                                                        <img src="/TEST/nature/3/etape.png"  id="signataire">
                                                        <h4 class="m-t-20"><span class="text-c-blue">
                                                          
                                                        </span> ETAPE 3</h4>
                                                        <p class="m-b-20">Kit alimentaire 2 (20$ SSI) </p>
                                                        <button class="btn btn-primary btn-sm btn-round">{{ App\Providers\InterfaceServiceProvider::valPV(3) }} PV</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-lg-4">
                                                <div class="card">
                                                    <div class="card-block text-center">
                                                        <img src="/TEST/nature/4/etape.png"  id="signataire">
                                                        <h4 class="m-t-20"><span class="text-c-blue">
                                                          
                                                        </span> ETAPE 4</h4>
                                                        <p class="m-b-20">Smartphone + Kit alimentaire ou appareil electro menager (140$ SSI) </p>
                                                        <button class="btn btn-primary btn-sm btn-round">{{ App\Providers\InterfaceServiceProvider::valPV(4) }} PV</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-lg-4">
                                                <div class="card">
                                                    <div class="card-block text-center">
                                                        <img src="/TEST/nature/5/etape.png"  id="signataire">
                                                        <h4 class="m-t-20"><span class="text-c-blue">
                                                          
                                                        </span> ETAPE 5</h4>
                                                        <p class="m-b-20">Moto + Kit alimentaire ou appareil electro menager ou »PC (1300$ SSI) </p>
                                                        <button class="btn btn-primary btn-sm btn-round">{{ App\Providers\InterfaceServiceProvider::valPV(5) }} PV</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-lg-4">
                                                <div class="card">
                                                    <div class="card-block text-center">
                                                        <img src="/TEST/nature/6/etape.png"  id="signataire">
                                                        <h4 class="m-t-20"><span class="text-c-blue">
                                                          
                                                        </span> ETAPE 6</h4>
                                                        <p class="m-b-20">Voiture + Kit alimentaire ou appareil electro menager (15000$ SSI)</p>
                                                        <button class="btn btn-primary btn-sm btn-round">{{ App\Providers\InterfaceServiceProvider::valPV(6) }} PV</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-lg-4">
                                                <div class="card">
                                                    <div class="card-block text-center">
                                                        <img src="/TEST/nature/7/etape.png"  id="signataire">
                                                        <h4 class="m-t-20"><span class="text-c-blue">
                                                          
                                                        </span> ETAPE 7</h4>
                                                        <p class="m-b-20">voiture 4×4 +  voyage d'affaire + Kit alimentaire (40.000) </p>
                                                        <button class="btn btn-primary btn-sm btn-round">{{ App\Providers\InterfaceServiceProvider::valPV(7) }} PV</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-lg-4">
                                                <div class="card">
                                                    <div class="card-block text-center">
                                                        <img src="/TEST/nature/8/etape.png"  id="signataire">
                                                        <h4 class="m-t-20"><span class="text-c-blue">
                                                          
                                                        </span> ETAPE 8</h4>
                                                        <p class="m-b-20">Maison + Voiture 4×4 + Kit alimentaire ou appareil electro menager (350.000$ SSI) </p>
                                                        <button class="btn btn-primary btn-sm btn-round">{{ App\Providers\InterfaceServiceProvider::valPV(8) }} PV</button>
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