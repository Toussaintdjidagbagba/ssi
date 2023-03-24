@extends('layouts.template')


@section('content')

<section id="services">
  <div class="container">

    <div class=" my-5">
      <div class="card-body p-0">
        <!--div class="progress">
            <div class=" progress-bar-striped progress-bar-animated" role="progressbar" style="width: 60%" id="progres" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
        </div-->
        <!-- Nested Row within Card Body -->
        <div class="row" style="background-color: rgba(255, 255, 255, 0.5);">
          
          <div class="col-xl-8 col-lg-8 col-md-10 col-sm-10 col-xs-10  col-xl-offset-2 col-lg-offset-2 col-md-offset-1 col-xs-offset-1 col-sm-offset-1 at-itemt
          ">
            <div class="p-5">
              <!-- Titre -->
              <div class="text-center" style="margin-top: 20px;">
                    <p style="color: #4f2e14; font-size: x-large;"> <b>EFFECTUEZ LE PAIEMENT POUR VALIDER LA CREATION DU COMPTE</b> </p> <br>
                    
                  </div>
              <div class="text-center">
                @include('flash::message')
              </div>

              <!-- Formulaire de création de compte -->
               <form class="user at-itemt" method="post" action="{{ route('validerpayementT') }}"> 
              
                {{ csrf_field() }}
                <br>
                
                <div class="form-group">
                    <label>Code d'approbation <i style="color: red">*</i></label>
                    <input type="text" class="form-control" name="parraincode" id="input" placeholder="Code d'approbation" data-original-title="Code d'approbation" /> 
                </div>

                                        
                    <button type="submit" class="btn btn-user btn-block" id="bouton">
                      <b style="color: #fff">VALIDER</b>
                    </button>               
            </form>
              <hr>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>
@endsection('content')


@section('stylesheet')

<style type="text/css">
@media only screen and (min-width: 760px) {
  #log_image{
      height: 200px; width: 420px; margin-top: -55px;
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
