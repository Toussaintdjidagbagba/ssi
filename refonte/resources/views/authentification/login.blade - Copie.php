@extends('layouts.templatetest')

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
    <div class="row justify-content-center" >
      <div class="col-xl-8 col-lg-8 col-md-7 col-sm-5 col-xs-5">
        <div class="text-center">
          @include('flash::message')
        </div>
      </div>

      <div class="col-xl-8 col-lg-8 col-md-7 col-sm-5 col-xs-5 at-item" >

        <div class=" my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row" >
              <div class="col-lg-2">
                
              </div>
              <div class="col-lg-8" style="background-color: rgba(255, 255, 255, 0.5);">
                <div class="p-5">
                  <div class="text-center" style="">
                    <img src="img/c_ssi.png" id="log_image"> <br> <br>
                  </div>
                  <form class="user at-itemt" method="post" action="{{ route('seconnecterS') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                      <input type="text" class="form-control " id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Pseudo ou identifiant" name="mail">
                      @if($errors->has('mail'))
                        <p style="color: red; font-size: 8px"> {{ $errors->first('mail') }}</p>
                      @endif
                    </div>
                     
                    <div class="form-group">
                      <input type="password" class="form-control " id="exampleInputPassword" placeholder="Mot de passe" name="password">
                      @if($errors->has('password'))
                        <p style="color: red; font-size: 8px"> {{ $errors->first('password') }}</p>
                      @endif
                    </div>
                    
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck" name="sourvenir">
                        <label class="custom-control-label" for="customCheck">Se sourvenir de moi</label>
                      </div>
                    </div>
                    
                    <button type="submit" class="btn btn-user btn-block" id="but">
                      <b>CONNEXION</b>
                    </button>
                  
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="{{route('fogot')}}">Mot de passe oublié?</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="{{route('inscription')}}">Créer un compte!</a>
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