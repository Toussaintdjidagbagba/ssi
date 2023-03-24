@extends('layouts.template_admin')

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
                <h1 class="h4 text-gray-900 mb-4">ENVOYER RECU HEALTH & WEALTH</h1>
              </div>

              <div class="text-center">
                @include('flash::message')
              </div>
              <!-- Formulaire de création de compte -->
              <form class="user" method="post" action="{{ route('healthrecuS') }}"> 
                {{ csrf_field() }}
              
                <div class="form-group">
                  <label>Référence du recu H & W SSI : </label>
                  <input type="text" class="form-control" name="refrecu" value="{{ $demande->RefRecu }}" disabled="true" >
                  <input type="hidden" class="form-control" name="refrecu" value="{{ $demande->RefRecu }}"> 
                  <input type="hidden" class="form-control" name="CodePersoUser" value="{{ $demande->CodePersoUser }}">

                </div>


                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Nom :</label>
                    <input type="text" class="form-control" name="nom" value="{{ $demande->Nom }}" disabled="true">
                    <input type="hidden" class="form-control" name="nom" value="{{ $demande->Nom }}">
                    <input type="hidden" class="form-control" name="pseudo" value="{{ $demande->pseudo }}">
                  </div>
                  
                  <div class="col-sm-6">
                    <label>Prénom :</label>
                    <input type="text" class="form-control " name="prenom" value="{{ $demande->Prenom }}" disabled="true">
                    <input type="hidden" class="form-control " name="prenom" value="{{ $demande->Prenom }}">
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Mail :</label>
                    <input type="text" class="form-control" name="mail" value="{{ $demande->Email }}" disabled="true">

                    <input type="hidden" class="form-control" name="mail" value="{{ $demande->Email }}">
                  </div>
                  
                  <div class="col-sm-6">
                    <label>Téléphone :</label>
                    <input type="text" class="form-control " name="tel" value="{{ $demande->Tel }}" disabled="true">
                    <input type="hidden" class="form-control " name="tel" value="{{ $demande->Tel }}">
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Pseudo :</label>
                    <input type="text" class="form-control" name="pseudo" value="{{ $demande->pseudo }}" disabled="true">
                    <input type="hidden" class="form-control" name="pseudo" value="{{ $demande->pseudo }}">
                  </div>
                  
                  <div class="col-sm-6">
                    <label>Date :</label>
                    <input type="text" class="form-control " name="dateH" value="{{ $demande->dateH }}" disabled="true">
                    <input type="hidden" class="form-control " name="dateH" value="{{ $demande->dateH }}">
                  </div>
                </div> 

                <div class="form-group">
                    <label>Pays :</label>
                    <input type="text" class="form-control" name="pays" value="{{ $demande->pays }}" disabled="true">
                    <input type="hidden" class="form-control" name="pays" value="{{ $demande->pays }}">
                  </div>

                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Libelle Service :</label>
                    <input type="text" class="form-control" name="libelle" value="INSCRIPTION HEALTH & WEALTH" disabled="true">
                    <input type="hidden" class="form-control" name="libelle" value="INSCRIPTION HEALTH & WEALTH">
                  
                  </div>
                  
                  <div class="col-sm-6">
                    <label>Mode de règlement :</label>
                    <input type="text" class="form-control" name="modereglement" value="En ligne. COMPTE AVOIR" disabled="true">
                    <input type="hidden" class="form-control" name="modereglement" value="COMPTE AVOIR">
                  </div>
                </div>

                <div class="form-group">
                  <label>Montant Payer en $ SSI:</label>
                  <input type="text" class="form-control" name="montant" value="{{ $demande->MontantPayer }}" disabled="true" >
                  
                  <input type="hidden" class="form-control" name="montant" value="{{ $demande->MontantPayer }}" >
                </div>

                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>LIEN :</label>
                    <input type="text" class="form-control" name="lien" placeholder="Entrer le lien">
                    @if($errors->has('lien'))
                      <p style="color: red"> {{ $errors->first('lien') }}</p>
                    @endif
                  </div>
                  
                  <div class="col-sm-6">
                    <label>Mot de passe :<i style="color: red">*</i></label>
                    <input type="text" class="form-control " name="pass" placeholder="Entrer le mot de passe">
                    @if($errors->has('pass'))
                      <p style="color: red"> {{ $errors->first('pass') }}</p>
                    @endif
                  </div>
                </div>
              

                <input type="submit" name="ENVOYER RECU" value="ENVOYER RECU" class="btn btn-user btn-block" id="but" />
                
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