@extends('layouts.template')

@section('content')

<section id="services" >

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="text-center">
          @include('flash::message')
        </div>
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
                    <h1 style="color: #4f2e14; font-size: x-large;" class="h4 text-gray-900 mb-4">Réinitilisation de mot de passe</h1>
                  </div>
                  <form class="user" method="post" action="{{ route('fogotS') }}">
                    {{ csrf_field() }}
                     
                      <input type="hidden" name="mail" value="{{ $mail }}">
                      <input type="hidden" name="message" value="{{ $message }}">
                      <input type="hidden" name="codeperso" value="{{ $codeperso }}">
                    
                    <div class="form-group">
                      <input id="input" type="text" class="form-control form-control-user" required="Renseigner le message envoyé par mail ici"  placeholder="Renseigner le message envoyé par mail ici" name="mes">
                      @if($errors->has('mes'))
                          <p style="color: red"> {{ $errors->first('mes') }}</p>
                      @endif
                    </div>

                    <div class="form-group">
                      <input id="input" type="password" class="form-control form-control-user" id="exampleInputPassword" required="Veuillez renseigner le nouveau svp" placeholder="Nouveau mot de passe" name="password">
                      @if($errors->has('password'))
                          <p style="color: red"> {{ $errors->first('password') }}</p>
                      @endif
                    </div>

                    <div class="form-group">
                      <input id="input" type="password" class="form-control form-control-user" id="exampleInputPassword" required="Veuillez renseigner le nouveau svp" placeholder="Répété le mot de passe" name="passwordbis">
                      @if($errors->has('passwordbis'))
                          <p style="color: red"> {{ $errors->first('passwordbis') }}</p>
                      @endif
                    </div>
                    
                    <button type="submit" class="btn btn-user btn-block" id="bouton">
                      <b style="color: #fff ">VALIDER</b>
                    </button>
                  
                  </form>
                  <hr>
                  <!--<div class="text-center">
                    <form action="{{route('fogotRR')}}" method="post">
                      {{ csrf_field() }}
                      <input type="hidden" name="mail" value="{{ $mail }}">
                      <input type="hidden" name="message" value="{{ $message }}">
                    <input class="small" type="submit" value="Renvoyer le message." id="but" />
                    </form>
                    <br> -->
                  <div class="text-center">
                    <a class="small" href="{{route('inscription')}}" style="color: #4f2e14;">Créer un compte!</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="{{route('seconnecter')}}" style="color: #4f2e14;">Je me rappel!</a>
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