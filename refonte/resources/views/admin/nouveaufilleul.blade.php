@extends('layouts.template_admin')

@section('css') 
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
      <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                    Créer un compte pour un filleul
                    </h2>
                </div>
                <div class="text-center">
                  @include('flash::message')
                </div>
                <div class="body">
                    <form  class="user" style="border: 0.5px solid gray; padding: 20px" method="post" action="{{ route('ajoutfilleul') }}">
                    {{ csrf_field() }}    
                        <label for="pseudo">Pseudo <i style="color: red">*</i></label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" class="form-control " name="pseudo" id="pseudo" placeholder="Entrer votre Pseudo" value="{{ old('pseudo') }}" data-original-title="Entrer votre Pseudo">
                            </div>
                            @if($errors->has('pseudo'))
                              <p style="color: red"> {{ $errors->first('pseudo') }}</p>
                            @endif
                        </div>

                        <label for="nom">Nom<i style="color: red">*</i></label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" class="form-control " name="nom" id="nom" placeholder="Entrer votre nom" data-original-title="Entrer votre nom" >
                            </div>
                            @if($errors->has('nom'))
                              <p style="color: red"> {{ $errors->first('nom') }}</p>
                            @endif
						            </div>
						
						            <label for="prenom">Prenom<i style="color: red">*</i></label>
                        <div class="form-group">
                            <div class="form-line">
							              <input type="text" class="form-control " name="prenom" id="prenom" placeholder="Entrer votre prénom" data-original-title="Entrer votre prénom">
                            </div>
                            @if($errors->has('prenom'))
                              <p style="color: red"> {{ $errors->first('prenom') }}</p>
                            @endif
                        </div>

                        <div class="col-sm-12" >
                          <label for="pays">Pays<i style="color: red">*</i></label>
                          <select class="form-control show-tick" type="mail"  name="pays" id="pays" placeholder="Entrer votre Pays" data-original-title="Entrer votre Pays">
                              <option value="">Bénin</option>
                              @foreach($pays as $pay)
                                <option>{{ $pay->libelle }}</option>
                              @endforeach
                          </select>
                        </div>

                        <label style="margin-top: 25px !important;" for="tel">Téléphone<i style="color: red">*</i></label>
                        <div class="form-group">
                            <div class="form-line">
							              <input type="tel" class="form-control " name="tel" id="tel" placeholder="Entrer votre téléphone" data-original-title="Entrer votre téléphone">
                            </div>
                            @if($errors->has('tel'))
                              <p style="color: red"> {{ $errors->first('tel') }}</p>
                            @endif
                        </div>

                        <label for="mail">E-mail<i style="color: red">*</i></label>
                        <div class="form-group">
                            <div class="form-line">
							              <input type="mail" class="form-control " name="mail" id="mail" placeholder="Entrer votre E-mail" value="{{ old('mail') }}" data-original-title="Entrer votre E-mail">
                            </div>
                            @if($errors->has('mail'))
                              <p style="color: red"> {{ $errors->first('mail') }}</p>
                            @endif
                        </div>

                        <label for="parrain">Code parrain<i style="color: red">*</i></label>
                        <div class="form-group">
                            <div class="form-line">
                            <input type="text" class="form-control " name="parrain" id="parrain" placeholder="Code de parrainage" data-original-title="Entrer votre Pays" /> 
                            <div class="form-check">
                              <input type="checkbox" class="form-check-input" id="parain" name="cocherparrain" value="Pas de code de parrainage.">
                              <label class="form-check-label" for="parain">Pas de code de parrainage.</label>
                            </div>
                            </div>
                        </div>

                        <div class="col-sm-12" >
                          <label for="payement">Moyen de Paiement<i style="color: red">*</i></label>
                          <select class="form-control show-tick" type="text" name="payement" id="payement" data-original-title="Entrer votre moyen de payement">
                              @foreach($mps as $mp)
                                <option>{{ $mp->libelle }}</option>
                              @endforeach
                          </select>
                        </div>

                        <div class="col-sm-12" style="margin-top: 25px !important;" >
                          <label for="sexe">Sexe<i style="color: red">*</i></label>
                          <select class="form-control show-tick" type="text" name="sexe" id="sexe" placeholder="Entrer votre Sexe" data-original-title="Entrer votre Sexe">
                            <option>Masculin</option>
                            <option>Féminin</option>
                          </select>
                        </div>

                        <div class="col-sm-12" style="margin-top: 25px !important;">
                          <label for="educ">Formation<i style="color: red">*</i></label>
                          <select class="form-control show-tick" type="educ" name="educ" style="margin-top: 8px" id="educ" placeholder="Education financière" data-original-title="Education financière">
                          <option>Education financière</option>
                          </select>
                        </div>

                        <div class="col-sm-12" style="margin-top: 25px !important;" >
                          <label for="pack">Pack d'adhésion<i style="color: red">*</i></label>
                          <select class="form-control show-tick" type="text" name="pack" id="pack" placeholder="Entrer votre pack d'adhésion" data-original-title="Entrer votre pack d'adhésion">
                          <option>10 {{$monnaie[0]->Monnaie}}</option>
                          <option>60 {{$monnaie[0]->Monnaie}}</option>
                          </select>
                        </div>

                        <div class="col-sm-12" style="margin-top: 25px !important;">
                          <label for="payerf">Fait payer mon filleul<i style="color: red">*</i></label>
                          <select class="form-control show-tick" type="text" name="payerf"  id="payerf" placeholder="Payer" data-original-title="Payer">
                          <option>NON</option>
                          <option>OUI</option>
                          </select>
                        </div>

                        <label style="margin-top: 25px !important;" for="password">Mot de passe<i style="color: red">*</i></label>
                        <div class="form-group">
                            <div class="form-line">
							              <input type="password" class="form-control" name="password" id="password" placeholder="Entrer votre mot de passe" data-original-title="Entrer votre mot de passe">
                            </div>
                            @if($errors->has('password'))
                              <p style="color: red"> {{ $errors->first('password') }}</p>
                            @endif
                        </div>

                        <label for="passwordbis">Répété le mot de passe<i style="color: red">*</i></label>
                        <div class="form-group">
                            <div class="form-line">
							              <input type="password" class="form-control" name="passwordbis" id="password" placeholder="Entrer une fois de plus votre mot de passe" data-original-title="Entrer une fois de plus votre mot de passe">
                            </div>
                            @if($errors->has('passwordbis'))
                              <p style="color: red"> {{ $errors->first('passwordbis') }}</p>
                            @endif
                        </div>

                        
                        
                        <br>
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect" name="CREER COMPTE" value="CREER COMPTE" class="btn btn-user btn-block" id="but">CREER COMPTE</button>
                    </form>
                </div>
            </div>
        </div>
      </div>       

    </div>
</section>

@endsection