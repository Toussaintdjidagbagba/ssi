@extends('layouts.template')

@section('content')
<section id="services">
  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-8 col-lg-8 col-md-10 col-sm-10 col-xs-10  col-xl-offset-2 col-lg-offset-2 col-md-offset-1 col-xs-offset-1 col-sm-offset-1 at-itemt">

        <div class=" my-5">
          <div class="card-body p-0">
            
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-2">
                
              </div>
              <div class="col-lg-8">
                <div class="form-group">
                </div>
                <div class="p-5">
                  <div class="text-center">
                      <img src="img/vali.png" style="height: 200px; width: 200px">
                  </div>
                  <center>
                    
                      <p>Veuillez laisser un message contenant les identifiants ci-dessous à l'administrateur via la page contactez-nous pour qu'il vous active les comptes qui n'ont pas pu être activé suite à une interruption lors de la création des comptes, faute de connexion ou arrêt sur le serveur. </p> 
                  </center>
                      <ul>
                      @for($i=1; $i < count($identifiants); $i++)
                        
                          <li>Identifiant {{$i}} : {{ $identifiants[$i] }}</li>
                        
                      @endfor
                      </ul>
                    
                  
                  <hr>
                  <div class="text-center">
                    <a class="small" href="{{ route('seconnecter')}}" id="bouton" style="color:#fff">Se connecter à présent.</a>
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
@endsection('content')