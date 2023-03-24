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
                    Profil
                    </h2>
                </div>
                <div class="text-center">
                  @include('flash::message')
                </div>
                <div class="body">
                    <form  class="user" style="border: 0.5px solid gray; padding: 20px" method="post" action="{{ route('ajoutfilleul') }}">
                    {{ csrf_field() }}    
                        <label for="codepersonnel">Code Personnel<i style="color: red">*</i></label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="number"  class="form-control " name="codepersonnel" id="codepersonnel" value="{{ $users[0]->codeperso }}" disabled="true" >
                            </div>
                            @if($errors->has('codepersonnel'))
                              <p style="color: red"> {{ $errors->first('codepersonnel') }}</p>
                            @endif
                        </div>

                        <label for="nom">Nom<i style="color: red">*</i></label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text"  class="form-control " name="nom" id="nom" value="{{ $users[0]->nom}}" id="nom" placeholder="Entrer votre nom" >
                            </div>
                            @if($errors->has('nom'))
                              <p style="color: red"> {{ $errors->first('nom') }}</p>
                            @endif
                        </div>

                        <label for="prenom">Prénom<i style="color: red">*</i></label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text"  class="form-control " name="prenom" id="prenom" placeholder="Entrer votre prénom" data-original-title="Entrer votre prénom" value="{{ $users[0]->prenom}}" >
                            </div>
                            @if($errors->has('prenom'))
                              <p style="color: red"> {{ $errors->first('prenom') }}</p>
                            @endif
                        </div>

                        <label for="sexe">Sexe<i style="color: red">*</i></label>
                        <div class="form-group">
                            <div class="form-line">
                                <input value="{{ $users[0]->sexe}}" type="text" class="form-control"  name="sexe" id="sexe" placeholder="Entrer votre Sexe" data-original-title="Entrer votre Sexe" >
                            </div>
                        </div>


                        <label for="tel">Téléphone<i style="color: red">*</i></label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="tel"  class="form-control " value="{{ $users[0]->tel}}" name="tel" id="tel" placeholder="Entrer votre téléphone" data-original-title="Entrer votre téléphone">
                            </div>
                            @if($errors->has('tel'))
                              <p style="color: red"> {{ $errors->first('tel') }}</p>
                            @endif
                        </div>


                        <label for="mail">E-mail<i style="color: red">*</i></label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="mail" class="form-control " name="mail" id="mail" value="{{ $users[0]->email}}" placeholder="Entrer votre E-mail" data-original-title="Entrer votre E-mail" disabled="true" >
                            </div>
                            @if($errors->has('mail'))
                              <p style="color: red"> {{ $errors->first('mail') }}</p>
                            @endif
                        </div>


                        <label for="parrain">Mon parrain<i style="color: red">*</i></label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" class="form-control " name="parrain" id="parrain" placeholder="Code de parrainage" data-original-title="Entrer votre Parrain" disabled="true" value="{{ $users[0]->parrain}}" >
                            </div>
                        </div>


                        <label for="codeunique">Mon code de parrainnage<i style="color: red">*</i></label>
                        <div class="form-group">
                            <div class="form-line">
                                <input  value="{{ $users[0]->codeunique}}" type="text" class="form-control"  name="codeunique" id="codeunique" data-original-title="Entrer votre code unique" disabled="true">
                            </div>
                        </div>


                        <label for="prenom">Prénom<i style="color: red">*</i></label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text"  class="form-control " name="prenom" id="prenom" placeholder="Entrer votre prénom" data-original-title="Entrer votre prénom" value="{{ $users[0]->prenom}}" >
                            </div>
                            @if($errors->has('prenom'))
                              <p style="color: red"> {{ $errors->first('prenom') }}</p>
                            @endif
                        </div>


                        <label for="nomuser">Nom d'utilisateur ou pseudo<i style="color: red">*</i></label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" class="form-control " name="nomuser" id="nomuser" value="{{ $users[0]->nomuser}}" disabled="true" >
                            </div>
                            @if($errors->has('nomuser'))
                              <p style="color: red"> {{ $errors->first('nomuser') }}</p>
                            @endif
                        </div>
                        
                        <br>
                        <button type="submit" name="mettreajour" value="Mettre à jour" id="but" class="btn btn-primary m-t-15 waves-effect">Mettre à jour</button>
                    </form>
                </div>
            </div>
        </div>
      </div>       

    </div>
</section>  



</div>
@endsection