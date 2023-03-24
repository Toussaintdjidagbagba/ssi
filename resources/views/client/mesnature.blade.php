@extends('layouts.templaterefonte')

@section('content')

<div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <div class="main-body">
                                <div class="page-wrapper">

                                    <div class="page-body">
                                      <div class="row">
                                        <div class="col-lg-12">
                                          <h3 class="page-header">Mes natures</h3>
                                        </div>
                                       

          @switch($etape)
          
            @case(1)
                <div class="col-md-12 col-lg-4">
                    <div class="card">
                       <div class="card-block text-center">
                        <img src="/TEST/nature/1/etape.png"  id="signataire">
                        <h4 class="m-t-20"><span class="text-c-blue">
                        
                        </span> ETAPE 1</h4>
                        <p class="m-b-20">Tee shirt SSI + KIT de demarrage (12$ SSI) </p>
                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
                    </div>
                </div>
                </div>
                @break
            @case(2)
                <div class="col-md-12 col-lg-4">
                    <div class="card">
                       <div class="card-block text-center">
                        <img src="/TEST/nature/1/etape.png"  id="signataire">
                        <h4 class="m-t-20"><span class="text-c-blue">
                        
                        </span> ETAPE 1</h4>
                        <p class="m-b-20">Tee shirt SSI + KIT de demarrage (12$ SSI) </p>
                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
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
                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
                    </div>
                </div>
                </div>
                @break
            @case(3)
                <div class="col-md-12 col-lg-4">
                                                <div class="card">
                                                    <div class="card-block text-center">
                                                        <img src="/TEST/nature/1/etape.png"  id="signataire">
                                                        <h4 class="m-t-20"><span class="text-c-blue">
                                                          
                                                        </span> ETAPE 1</h4>
                                                        <p class="m-b-20">Tee shirt SSI + KIT de demarrage (12$ SSI) </p>
                                                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
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
                                                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
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
                                                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
                                                    </div>
                                                </div>
                                            </div>
                @break
            @case(4)
                <div class="col-md-12 col-lg-4">
                                                <div class="card">
                                                    <div class="card-block text-center">
                                                        <img src="/TEST/nature/1/etape.png"  id="signataire">
                                                        <h4 class="m-t-20"><span class="text-c-blue">
                                                          
                                                        </span> ETAPE 1</h4>
                                                        <p class="m-b-20">Tee shirt SSI + KIT de demarrage (12$ SSI) </p>
                                                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
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
                                                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
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
                                                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
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
                                                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
                                                    </div>
                                                </div>
                                            </div>

                @break
            @case(5)
                <div class="col-md-12 col-lg-4">
                                                <div class="card">
                                                    <div class="card-block text-center">
                                                        <img src="/TEST/nature/1/etape.png"  id="signataire">
                                                        <h4 class="m-t-20"><span class="text-c-blue">
                                                          
                                                        </span> ETAPE 1</h4>
                                                        <p class="m-b-20">Tee shirt SSI + KIT de demarrage (12$ SSI) </p>
                                                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
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
                                                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
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
                                                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
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
                                                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-lg-4">
                                                <div class="card">
                                                    <div class="card-block text-center">
                                                        <img src="/TEST/nature/5/etape.png"  id="signataire">
                                                        <h4 class="m-t-20"><span class="text-c-blue">
                                                          
                                                        </span> ETAPE 5</h4>
                                                        <p class="m-b-20">Moto + Kit alimentaire ou appareil electro menager ou ð»PC (1300$ SSI) </p>
                                                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
                                                    </div>
                                                </div>
                                            </div>

                @break
            @case(6)
                <div class="col-md-12 col-lg-4">
                                                <div class="card">
                                                    <div class="card-block text-center">
                                                        <img src="/TEST/nature/1/etape.png"  id="signataire">
                                                        <h4 class="m-t-20"><span class="text-c-blue">
                                                          
                                                        </span> ETAPE 1</h4>
                                                        <p class="m-b-20">Tee shirt SSI + KIT de demarrage (12$ SSI) </p>
                                                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
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
                                                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
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
                                                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
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
                                                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-lg-4">
                                                <div class="card">
                                                    <div class="card-block text-center">
                                                        <img src="/TEST/nature/5/etape.png"  id="signataire">
                                                        <h4 class="m-t-20"><span class="text-c-blue">
                                                          
                                                        </span> ETAPE 5</h4>
                                                        <p class="m-b-20">Moto + Kit alimentaire ou appareil electro menager ou ð»PC (1300$ SSI) </p>
                                                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-lg-4">
                                                <div class="card">
                                                    <div class="card-block text-center">
                                                        <img src="/TEST/nature/6/etape.png"  id="signataire">
                                                        <h4 class="m-t-20"><span class="text-c-blue">
                                                          
                                                        </span> ETAPE 6</h4>
                                                        <p class="m-b-20">Voiture + Kit alimentaire ou appareil electro menager (1500$ SSI)</p>
                                                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
                                                    </div>
                                                </div>
                                            </div>

                @break
            @case(7)
                <div class="col-md-12 col-lg-4">
                                                <div class="card">
                                                    <div class="card-block text-center">
                                                        <img src="/TEST/nature/1/etape.png"  id="signataire">
                                                        <h4 class="m-t-20"><span class="text-c-blue">
                                                          
                                                        </span> ETAPE 1</h4>
                                                        <p class="m-b-20">Tee shirt SSI + KIT de demarrage (12$ SSI) </p>
                                                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
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
                                                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
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
                                                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
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
                                                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-lg-4">
                                                <div class="card">
                                                    <div class="card-block text-center">
                                                        <img src="/TEST/nature/5/etape.png"  id="signataire">
                                                        <h4 class="m-t-20"><span class="text-c-blue">
                                                          
                                                        </span> ETAPE 5</h4>
                                                        <p class="m-b-20">Moto + Kit alimentaire ou appareil electro menager ou ð»PC (1300$ SSI) </p>
                                                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-lg-4">
                                                <div class="card">
                                                    <div class="card-block text-center">
                                                        <img src="/TEST/nature/6/etape.png"  id="signataire">
                                                        <h4 class="m-t-20"><span class="text-c-blue">
                                                          
                                                        </span> ETAPE 6</h4>
                                                        <p class="m-b-20">Voiture + Kit alimentaire ou appareil electro menager (1500$ SSI)</p>
                                                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-lg-4">
                                                <div class="card">
                                                    <div class="card-block text-center">
                                                        <img src="/TEST/nature/7/etape.png"  id="signataire">
                                                        <h4 class="m-t-20"><span class="text-c-blue">
                                                          
                                                        </span> ETAPE 7</h4>
                                                        <p class="m-b-20">voiture 4×4 + âï¸ voyage d'affaire + Kit alimentaire (40.000) </p>
                                                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
                                                    </div>
                                                </div>
                                            </div>

                @break
            @case(8)
                <div class="col-md-12 col-lg-4">
                                                <div class="card">
                                                    <div class="card-block text-center">
                                                        <img src="/TEST/nature/1/etape.png"  id="signataire">
                                                        <h4 class="m-t-20"><span class="text-c-blue">
                                                          
                                                        </span> ETAPE 1</h4>
                                                        <p class="m-b-20">Tee shirt SSI + KIT de demarrage (12$ SSI) </p>
                                                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
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
                                                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
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
                                                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
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
                                                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-lg-4">
                                                <div class="card">
                                                    <div class="card-block text-center">
                                                        <img src="/TEST/nature/5/etape.png"  id="signataire">
                                                        <h4 class="m-t-20"><span class="text-c-blue">
                                                          
                                                        </span> ETAPE 5</h4>
                                                        <p class="m-b-20">Moto + Kit alimentaire ou appareil electro menager ou ð»PC (1300$ SSI) </p>
                                                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-lg-4">
                                                <div class="card">
                                                    <div class="card-block text-center">
                                                        <img src="/TEST/nature/6/etape.png"  id="signataire">
                                                        <h4 class="m-t-20"><span class="text-c-blue">
                                                          
                                                        </span> ETAPE 6</h4>
                                                        <p class="m-b-20">Voiture + Kit alimentaire ou appareil electro menager (1500$ SSI)</p>
                                                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-lg-4">
                                                <div class="card">
                                                    <div class="card-block text-center">
                                                        <img src="/TEST/nature/7/etape.png"  id="signataire">
                                                        <h4 class="m-t-20"><span class="text-c-blue">
                                                          
                                                        </span> ETAPE 7</h4>
                                                        <p class="m-b-20">voiture 4×4 + âï¸ voyage d'affaire + Kit alimentaire (40.000) </p>
                                                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
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
                                                        <button class="btn btn-primary btn-sm btn-round">SSI</button>
                                                    </div>
                                                </div>
                                            </div>

                @break

            @default
        @endswitch

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