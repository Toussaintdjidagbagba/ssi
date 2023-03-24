@extends('layouts.template')


@section('css') 
  <link href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
@endsection


@section('content')

<section id="services" >
  <div class="container">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        
      </div>

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-2">
                
              </div> 
              <div class="col-lg-8">
                <div class="p-5">
                  <div class="text-center">
                    @include('flash::message')
                  </div>
                  <div class="text-center">
                     <h1 style="color: #4f2e14; font-size: x-large;" class="h4 text-gray-900 mb-4">Abonnement canal+</h1> <br>
                  </div>
                  <form class="user" method="post" action="{{ route('canalplusS') }}">
                    {{ csrf_field() }}
                    
                    <div class="form-group">
                      <label>Numéro du décodeur, abonné ou téléphone</label>
                      <input id="input" type="number" class="form-control form-control-user"  placeholder="Saisir.." name="num" >
                      @if($errors->has('num'))
                        <p style="color: red"> Saisissez une numéro abonné</p>
                      @endif
                    </div>
                     
                     <div class="form-group">
                      <select type="text" class="form-control"  name="formule" id="input" placeholder="Entrer votre formule" data-original-title="Entrer votre formule">
                        <option style="color:black"><b>CHOISIR LA FORMULE :</b></option>
                        <option value="access1"> access [10 SSI] (5000 FCFA) </option>
                        <option value="evasion"> evasion [20 SSI] (10000 FCFA) </option>
                        <option value="essentiel"> essentiel + [26 SSI] (13000 FCFA) </option>
                        <option value="evasion2"> evasion + [40 SSI] (20000 FCFA) </option>
                        <option value="tcanal"> tout canal + [80 SSI] (40000 FCFA) </option>
                        <option value="ocharme"> option charme [12 SSI] (6000 FCFA) </option>
                        <option value="acces"> acces + [30 SSI] (15000 FCFA) </option>
                        <option value="ecran"> 2ème écran [12 SSI] (6000 FCFA) </option>
                        <option style="color:black">Modification d'abonnement : </option>
                        <option value="modif10">[ 10 SSI ] </option>
                        <option value="modif14">[ 14 SSI ] </option>
                        <option value="modif20">[ 20 SSI ] </option>
                        <option value="modif30">[ 30 SSI ] </option>
                        <option value="modif40">[ 40 SSI ] </option>
                        <option value="modif50">[ 50 SSI ] </option>
                        <option value="modif60">[ 60 SSI ] </option>
                        <option value="modif70">[ 70 SSI ] </option>
                    </select>
                    </div>

                     <div class="form-group">
                      <select type="number" class="form-control"  name="mois" id="input" placeholder="Mois" data-original-title="Entrer votre nombre de mois">
                        <option>Durée en mois</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                    </div>
                      
                    <button type="submit" class="btn btn-user btn-block" id="bouton">
                      <b style="color:#fff">Soumettre</b>
                    </button>
                  
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

 </div>
</section>
@endsection