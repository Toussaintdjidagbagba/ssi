@extends('layouts.template')

@section('stylesheet')
        <script amount="5000" 
        callback="https://sourcedusuccesinternational.com/MLM/public/validerinscription-"
        data="Payer"
        url="http://sourcedusuccesinternational.com/logo.jpeg"
        position="right" 
        theme="#0095ff"
        sandbox="true"
        key="893aa0f0dd0411eab357a1c9bcb5baf1"
        src="https://cdn.kkiapay.me/k.js"></script>

@endsection

@section('content')
<section>
  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <div class="progress">
            <div class=" progress-bar-striped progress-bar-animated" role="progressbar" style="width: 60%" id="progres" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-2">
            
          </div>
          <div class="col-lg-8">
            <div class="p-5">
              <!-- Titre -->
              <div class="text-center">
                <h4 class="h4 text-gray-900 mb-4">Effectuer le payement pour valider la création de votre compte</h4>
              </div>

              <!-- Formulaire de création de compte -->
              <!-- <form class="user" method="post" action="{{ route('validerpayementT') }}"> -->
              <form class="user" method="post" action="">
                {{ csrf_field() }}
                <br><br>
                <!-- Information -->
                <input id="input" type="hidden" name="id_user" value="">
                <div class="form-group">
                  <label>
                    Vous devez payer 10$ SS ( 1$ SS = 500 F CFA) qui représente les frais de votre inscription dans le système.
                  </label>
                </div>

                <div class="form-group">
                  
                </div>                
            </form>
            
                <button class="kkiapay-button btn btn-user btn-block" id="bouton"> PAYER </button> 
              <hr>
              <img src="img/mastercard.png" style="height: 150px; width: 150px">
              <img src="img/mtn-mobile-money-benin.jpg" style="height: 100px; width: 100px">
              <img src="img/flooz-benin.png" style="height: 100px; width: 100px">
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>
@endsection('content')
