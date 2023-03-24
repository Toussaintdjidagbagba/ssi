@extends('layouts.template')

@section('header')
  <header class="masthead" style="background-image: url('img/home-bg.jpg')">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="site-heading">
            <h2>La Source du Succès International</h2>
            <span class="subheading">Se connecter ou S'inscrire</span>
          </div>
        </div>
      </div>
    </div> 
  </header>
@endsection 

@section('stylesheet')

<style type="text/css">
@media only screen and (min-width: 760px) {
  #log_image{
      height: 150px; width: 300px; margin-top: -55px
  }
}

@media only screen and (max-width: 760px) {
  #log_image{
      height: 150px; width: 300px; margin-top: -55px; margin-left: -40px;
  }
}

    .at-itemt {
      
      animation-name: shutter-in-top;
      animation-duration: 6s;
      animation-timing-function: ease;
      animation-delay: 0s;
      animation-iteration-count: 1;
      animation-direction: normal;
      animation-fill-mode: none;
    }
    @keyframes shutter-in-top {
      0%{
        -webkit-transform: rotateX(-100deg);
        transform: rotateX(-100deg);
        -webkit-transform-origin: top;
        transform-origin: top;
        opacity: 0;
      }
      100%{
        -webkit-transform: rotateX(0deg);
        transform: rotateX(0deg);
        -webkit-transform-origin: top;
        transform-origin: top;
        opacity: 1;
      }
    }


</style>

@endsection 


@section('content')
  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9 at-item">

        <div class=" my-5">
          <div class="card-body p-0">
            
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-2">
                
              </div>
              <div class="col-lg-8" style="background-color: rgba(255, 255, 255, 0.5);">
                <div class="form-group">
                </div>
                <div class="p-5">
                  <div class="text-center">
                      <img src="img/vali.png" style="height: 150px; width: 150px">
                  </div>
                  <center>
                    <h3>ECHEC!!!</h3>
                    <h4>Le solde de votre parrain est insuffisant. Veuillez le contacté pour en savoir davantage. Merci!!!</h4>
                    <h6>
                    <p style="color: red; text-align: justify;">
                      Consulter votre boite mail pour vous assuré de la création effective de(s) compte(s) . 
                      Si la création n'est pas effectuée veuillez consulter votre compte et/ou nous contacté mentionnant le dernier compte créé avec succès en plus de votre identifiant, votre adresse mail et le pseudo . 
                    </p>
                    </h6>
                  </center>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="{{ route('seconnecter')}}" id="link">Se connecter à présent.</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

@endsection('content')