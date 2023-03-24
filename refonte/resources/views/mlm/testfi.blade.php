<?php
  session(['G_parrain' => 1]);
?>

@extends('layouts.template')

@section('header')
  <header class="masthead" style="background-image: url('img/home-bg.jpg')">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="site-heading">
            <h2>La Source du Succès International</h2>
            <span class="subheading">S'inscrire</span>
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
      animation-duration: 4.2s;
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

    <div class=" my-5 ">
      <div class="card-body p-0">
        <div class="progress">
            <div class=" progress-bar-striped progress-bar-animated" role="progressbar" style="width: 30%" id="progres" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <!-- Nested Row within Card Body -->
        <div class="row" style="background-color: rgba(255, 255, 255, 0.5);">
          <div class="col-lg-2">
            
          </div>
          <div class="  col-xl-8 col-lg-8 col-md-7 col-sm-5 col-xs-5">
            <div class="p-5">
              <!-- Titre -->
              <div class="text-center ">
                <img src="img/create_ssi.png" id="log_image"> <br>
              </div>

              <div class="text-center">
                @include('flash::message')
              </div>
              <!-- Formulaire de création de compte -->
              <form class="user at-itemt" method="post" action="{{ route('inscriptionS') }}">
                {{ csrf_field() }}

                <!-- Pseudo -->
                <div class="form-group">
                  <label>Pseudo <i style="color: red">*</i></label>
                  <input type="text" class="form-control " name="pseudo" id="pseudo" placeholder="Entrer votre pseudo" value="{{ old('pseudo') }}" data-original-title="Entrer votre Pseudo">
                  @if($errors->has('pseudo'))
                      <p style="color: red; font-size: 8px"> {{ $errors->first('pseudo') }}</p>
                  @endif
                </div>

                <!-- Nom et Prénom -->
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Nom <i style="color: red">*</i></label>
                    <input type="text" class="form-control " name="nom" id="nom" placeholder="Entrer votre nom" data-original-title="Entrer votre nom">
                    @if($errors->has('nom'))
                      <p style="color: red; font-size: 8px"> <?php echo "Le nom ne peux pas etre vide."; ?></p>
                    @endif
                  </div>
                  
                  <div class="col-sm-6">
                    <label>Prenom <i style="color: red">*</i></label>
                    <input type="text" class="form-control " name="prenom" id="prenom" placeholder="Entrer votre prénom" data-original-title="Entrer votre prénom">
                    @if($errors->has('prenom'))
                      <p style="color: red; font-size: 8px"> {{ $errors->first('prenom') }}</p>
                    @endif
                  </div>
                </div>
                
                <!-- Pays et Tel -->
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <!-- Requete pour pays de la base de donnees--> 
                    <label>Pays <i style="color: red">*</i></label> 
                    <select type="mail" class="form-control"  name="pays" id="pays" placeholder="Entrer votre Pays" data-original-title="Entrer votre Pays">
                        <option>Bénin</option>
                        @foreach($pays as $pay)
                            <option>{{ $pay->libelle }}</option>
                          @endforeach
                    </select>
                  </div>
                  <div class="col-sm-6">
                    <label>Téléphone <i style="color: red">*</i></label>
                    <input type="tel" class="form-control " name="tel" id="tel" placeholder="Entrer votre téléphone" data-original-title="Entrer votre téléphone">
                    @if($errors->has('tel'))
                      <p style="color: red; font-size: 8px"> {{ $errors->first('tel') }}</p>
                    @endif
                  </div>
                </div>
 
                <!-- Mail -->
                <div class="form-group">
                  <label>E-mail <i style="color: red">*</i></label>
                  <input type="mail" class="form-control" name="mail" id="mail" placeholder="Entrer votre e-mail" value="{{ old('mail') }}" data-original-title="Entrer votre E-mail">
                  @if($errors->has('mail'))
                      <p style="color: red; font-size: 8px"> {{ $errors->first('mail') }}</p>
                  @endif
                </div>
                
                @if(isset($link))
                	<!-- Parrain et Payement -->
	                <div class="form-group row">
	                  <div class="col-sm-6 mb-3 mb-sm-0">
	                    
	                    <input type="hidden" class="form-control" name="parrain" id="parrain" value="{{$link}}" /> 
	                    
	                  </div>
	                  <div class="col-sm-6">
	                    <input type="hidden" class="form-control" name="payement" id="payement" value="MTN MONEY">
	                      
	                  </div>
	                </div>
                @else
                
                

                <!-- Parrain et Payement -->
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Code parrain <i style="color: red">*</i></label>
                    <input type="text" class="form-control" name="parrain" id="parrain" placeholder="Code de parrainage" data-original-title="Entrer code parrain" /> 
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="parain" name="cocherparrain" value="Pas de code de parrainage.">
                      <label class="form-check-label" for="parain">Pas de code de parrainage.</label>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <label>Moyen de Paiement <i style="color: red">*</i></label>
                    <select type="text" class="form-control" name="payement" id="payement" data-original-title="Entrer votre moyen de payement">
                      @foreach($mps as $mp)
                        <option>{{ $mp->libelle }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                @endif
                
                <!-- Sexe et Cout -->
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <!-- Requete pour pays de la base de donnees--> 
                    <label>Sexe <i style="color: red">*</i></label>
                    <select type="text" class="form-control" name="sexe" id="sexe" placeholder="Sélectionner votre sexe" data-original-title="Entrer votre sexe">
                      <option>Masculin</option>
                      <option>Féminin</option>
                    </select>  
                  </div>
                  <!-- Education financière -->
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Formation <i style="color: red">*</i></label>
                  <select type="text" class="form-control" name="educ"  id="educ" placeholder="Education financière" data-original-title="Education financière">
                    <option>Education financière</option>
                  </select>
                  </div>
                </div>

                <!-- Pack d'adhesion et consentement -->
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <!-- Requete pour pays de la base de donnees--> 
                    <label>Pack d'adhésion <i style="color: red">*</i></label>
                    <select type="text" class="form-control" name="pack" id="pack" placeholder="Entrer votre pack d'adhésion" data-original-title="Entrer votre pack d'adhésion">
                      <option>10 {{$monnaie[0]->Monnaie}}</option>
                      <option>60 {{$monnaie[0]->Monnaie}}</option>
                      <!-- <option>620 {{$monnaie[0]->Monnaie}}</option> -->
                      <!-- <option>5100 {{$monnaie[0]->Monnaie}}</option> -->
                    </select>  
                  </div>
                  <!-- Consentement -->
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Payer par mon parrain <i style="color: red">*</i></label>
                  <select type="text" class="form-control" name="payerf"  id="payerf" placeholder="Payer" data-original-title="Payer">
                    <option>OUI</option>
                    <option>NON</option>
                    
                  </select>
                  </div>
                </div>

                <!-- Password -->
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Mot de passe <i style="color: red">*</i></label>
                    <input type="password" class="form-control" name="password" id="password" style="font-size : 12px" placeholder="Entrer votre mot de passe" data-original-title="Entrer votre mot de passe">
                    @if($errors->has('password'))
                      <p style="color: red; font-size: 8px"> {{ $errors->first('password') }}</p>
                    @endif
                  </div>
                  
                  <div class="col-sm-6">
                    <label>Répété le mot de passe <i style="color: red">*</i></label>
                    <input type="password" class="form-control" name="passwordbis" id="password" style="font-size : 12px" placeholder="Confirmer votre mot de passe" data-original-title="Confirmer votre mot de passe">
                    @if($errors->has('passwordbis'))
                      <p style="color: red; font-size: 8px"> {{ $errors->first('passwordbis') }}</p>
                    @endif
                  </div>
                </div>

                <input type="submit" name="CREER COMPTE" value="CREER COMPTE" class="btn btn-user btn-block" id="but" />
                
              </form>
              <?php //location.reload(); 
              ?>
              <hr>
              <div class="text-center">
                <a class="small" href="{{route('fogot')}}" id="link">Mot de passe oublié? Cliquez moi</a>
              </div>
              <div class="text-center">
                <a class="small" href="{{ route('seconnecter')}}" id="link">J'ai un compte. Se connecter!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

@endsection('content')
