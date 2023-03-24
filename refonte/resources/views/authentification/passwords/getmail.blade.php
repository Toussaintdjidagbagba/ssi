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
                  <form class="user" method="post" action="{{ route('fogotR') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                      <label>Email <i style="color: red">*</i></label>
                      <input id="input" type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Entrer votre email" name="mail">
                      @if($errors->has('mail'))
                          <p style="color: red"> {{ $errors->first('mail') }}</p>
                      @endif
                    </div>

                    <div class="form-group">
                      <label>Identifiant <i style="color: red">*</i></label>
                      <input id="input" type="text" class="form-control form-control-user" id="" placeholder="Entrer votre identifiant" name="codeperso">
                      @if($errors->has('codeperso'))
                          <p style="color: red"> {{ $errors->first('codeperso') }}</p>
                      @endif
                    </div>

                    <div class="form-group">
                      <label>Pseudo</label>
                      <input id="input" type="text" class="form-control form-control-user" id="" placeholder="Ou entrer votre pseudo" name="nomuser">
                    </div>
                      <br>
                    <div class="text-center">
                      Un mail vous sera envoyé contenant un message.
                    </div>
                    
                    <button type="submit" class="btn btn-user btn-block" id="bouton">
                      <b style="color: #fff">Envoyer</b>
                    </button>
                  
                  </form>
                  <hr>
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