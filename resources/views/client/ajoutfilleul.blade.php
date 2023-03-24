@extends('layouts.template_client')
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta charset="UTF-8">
@section('css')
  <!-- Custom fonts for this template -->
  <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="{{asset('css/clean-blog.min.css')}}" rel="stylesheet">
  <link href="{{asset('css/mlm.css')}}" rel="stylesheet">
  
@endsection

@section('content')
	<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-2">
            
          </div>
          <div class="col-lg-8">
            <div class="p-5">
              <!-- Titre -->
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Créer un compte pour un filleul</h1>
              </div>
   
              <div class="text-center">
                @include('flash::message')
              </div>
              <!-- Formulaire de création de compte -->
              <form class="user" method="post" action="{{ route('ajoutfilleul') }}">
                {{ csrf_field() }}
              
                <!-- Pseudo -->
                <div class="form-group">
                  <label>Pseudo <i style="color: red">*</i></label>
                  <input type="text" class="form-control " name="pseudo" id="pseudo" placeholder="Entrer votre Pseudo" value="{{ old('pseudo') }}" data-original-title="Entrer votre Pseudo">
                  @if($errors->has('pseudo'))
                      <p style="color: red"> {{ $errors->first('pseudo') }}</p>
                  @endif
                </div>

                <!-- Nom et Prénom -->
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Nom <i style="color: red">*</i></label>
                    <input type="text" class="form-control " name="nom" id="nom" placeholder="Entrer votre nom" data-original-title="Entrer votre nom">
                    @if($errors->has('nom'))
                      <p style="color: red"> {{ $errors->first('nom') }}</p>
                    @endif
                  </div>
                  
                  <div class="col-sm-6">
                    <label>Prenom <i style="color: red">*</i></label>
                    <input type="text" class="form-control " name="prenom" id="prenom" placeholder="Entrer votre prénom" data-original-title="Entrer votre prénom">
                    @if($errors->has('prenom'))
                      <p style="color: red"> {{ $errors->first('prenom') }}</p>
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
                      <p style="color: red"> {{ $errors->first('tel') }}</p>
                    @endif
                  </div>
                </div>
 
                <!-- Mail -->
                <div class="form-group">
                  <label>E-mail <i style="color: red">*</i></label>
                  <input type="mail" class="form-control " name="mail" id="mail" placeholder="Entrer votre E-mail" value="{{ old('mail') }}" data-original-title="Entrer votre E-mail">
                  @if($errors->has('mail'))
                      <p style="color: red"> {{ $errors->first('mail') }}</p>
                  @endif
                </div>

                <!-- Parrain et Payement -->
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Code parrain <i style="color: red">*</i></label>
                    <input type="text" class="form-control " name="parrain" id="parrain" placeholder="Code de parrainage" data-original-title="Entrer votre Pays" /> 
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="parain" name="cocherparrain" value="Pas de code de parrainage.">
                      <label class="form-check-label" for="parain">Pas de code de parrainage.</label>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <label>Moyen de Paiement <i style="color: red">*</i></label>
                    <select type="text" class="form-control"  name="payement" id="payement" data-original-title="Entrer votre moyen de payement"> 
                      @foreach($mps as $mp)
                        <option>{{ $mp->libelle }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              
                <!-- Sexe et Cout -->
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <!-- Requete pour pays de la base de donnees-->
                    <label>Sexe <i style="color: red">*</i></label>
                    <select type="text" class="form-control"  name="sexe" id="sexe" placeholder="Entrer votre Sexe" data-original-title="Entrer votre Sexe">
                      <option>Masculin</option>
                      <option>Féminin</option>
                    </select>  
                  </div>
                  <!-- Education financière -->
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Formation <i style="color: red">*</i></label>
                  <select type="educ" class="form-control" name="educ" style="margin-top: 8px" id="educ" placeholder="Education financière" data-original-title="Education financière">
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
                    <label>Fait payer mon filleul <i style="color: red">*</i></label>
                  <select type="text" class="form-control" name="payerf"  id="payerf" placeholder="Payer" data-original-title="Payer">
                    <option>NON</option>
                    <option>OUI</option>
                  </select>
                  </div>
                </div>

                <!-- Password -->
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Mot de passe <i style="color: red">*</i></label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Entrer votre mot de passe" data-original-title="Entrer votre mot de passe">
                    @if($errors->has('password'))
                      <p style="color: red"> {{ $errors->first('password') }}</p>
                    @endif
                  </div>
                  
                  <div class="col-sm-6">
                    <label>Répété le mot de passe <i style="color: red">*</i></label>
                    <input type="password" class="form-control" name="passwordbis" id="password" placeholder="Entrer une fois de plus votre mot de passe" data-original-title="Entrer une fois de plus votre mot de passe">
                    @if($errors->has('passwordbis'))
                      <p style="color: red"> {{ $errors->first('passwordbis') }}</p>
                    @endif
                  </div>
                </div>

                <input type="submit" name="CREER COMPTE" value="CREER COMPTE" class="btn btn-user btn-block" id="but" />
                
              </form>
              <hr>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>


@endsection