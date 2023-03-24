@extends('layouts.template')

@section('content')

<section id="services" >
  <div class="container">

    
    <!-- Outer Row -->
    <div class="row justify-content-center" >
      <div class="col-xl-8 col-lg-8 col-md-10 col-sm-10 col-xs-10  col-xl-offset-2 col-lg-offset-2 col-md-offset-1 col-xs-offset-1 col-sm-offset-1 at-itemt">
        <div class="text-center">
          @include('flash::message')
        </div>
      </div>

      <div class="col-xl-8 col-lg-8 col-md-10 col-sm-10 col-xs-10  col-xl-offset-2 col-lg-offset-2 col-md-offset-1 col-xs-offset-1 col-sm-offset-1 at-itemt" >

        <div class=" my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row" >
              <div class="col-lg-2">
                
              </div>
              <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 " style="background-color: rgba(255, 255, 255, 0.5);">
                <div class="p-5">
                  <div class="text-center" style="margin-top: 20px;">
                    <p style="color: #4f2e14; font-size: large;"> <b>LA SSI A VOTRE SERVICE</b> </p> <br>
                    (Veuillez-vous connecter pour accéder à votre tableau de bord) <br>
                    <!--img src="img/c_ssi.png" id="log_image"--> <br> <br>
                  </div>
                  <form class="user at-itemt" method="post" action="{{ route('seconnecterS') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                      <input  type="text" class="form-control" id="input" aria-describedby="emailHelp" placeholder="Pseudo ou identifiant" name="mail">
                      @if($errors->has('mail'))
                        <p style="color: red; font-size: 8px"> {{ $errors->first('mail') }}</p>
                      @endif
                    </div>
                     
                    <div class="form-group">
                      <input type="password" class="form-control " id="input" placeholder="Mot de passe" name="password">
                      @if($errors->has('password'))
                        <p style="color: red; font-size: 8px"> {{ $errors->first('password') }}</p>
                      @endif
                    </div>
                    <button type="submit" class="btn btn-user btn-block" id="bouton">
                      <b style="color : #fff">CONNEXION</b>
                    </button>
                  
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="{{route('fogot')}}" style="color:#4f2e14">Mot de passe oublié?</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="{{route('inscription')}}" style="color:#4f2e14">Créer un compte!</a>
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
      animation-duration: 2s;
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
