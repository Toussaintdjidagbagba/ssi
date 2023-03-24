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
                <h1 class="h4 text-gray-900 mb-4">ENVOYER RECU SONEB</h1>
              </div>

              <div class="text-center">
                @include('flash::message')
              </div>
              <!-- Formulaire de création de compte -->
              <form class="user" method="post" action="{{ route('sonebrecuS') }}"> 
                {{ csrf_field() }}
              
                <div class="form-group">
                  <label>Référence du recu Soneb SSI : </label>
                  <input type="text" class="form-control" name="refrecu" value="{{ $demande->RefRecu }}" disabled="true" >
                  <input type="hidden" class="form-control" name="refrecu" value="{{ $demande->RefRecu }}"> 
                  <input type="hidden" class="form-control" name="CodePersoUser" value="{{ $demande->CodePersoUser }}">

                </div>


                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Nom :</label>
                    <input type="text" class="form-control" name="nom" value="{{ $demande->Nom }}" disabled="true">
                    <input type="hidden" class="form-control" name="nom" value="{{ $demande->Nom }}">
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
                    <label>Numéro WhatsApp :</label>
                    <input type="text" class="form-control " name="WhatsApp" value="{{ $demande->WhatsApp }}" disabled="true">
                    <input type="hidden" class="form-control " name="WhatsApp" value="{{ $demande->WhatsApp }}">
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Police du compteur :</label>
                    <input type="text" class="form-control" name="police" value="{{ $demande->Police }}" disabled="true">
                    <input type="hidden" class="form-control" name="police" value="{{ $demande->Police }}">
                  </div>
                  
                  <div class="col-sm-6">
                    <label>Présentation :</label>
                    <input type="text" class="form-control " name="presentation" value="{{ $demande->Presentation }}" disabled="true">
                    <input type="hidden" class="form-control " name="presentation" value="{{ $demande->Presentation }}">
                  </div>
                </div> 

                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Libelle Service :</label>
                    <input type="text" class="form-control" name="libelle" value="SONEB" disabled="true">
                    <input type="hidden" class="form-control" name="libelle" value="SONEB">
                  
                  </div>
                  
                  <div class="col-sm-6">
                    <label>Mode de règlement :</label>
                    <input type="text" class="form-control" name="modereglement" value="COMPTE AVOIR" disabled="true">
                    <input type="hidden" class="form-control" name="modereglement" value="COMPTE AVOIR">
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Montant Facture en $ SSI:</label>
                    <input type="text" class="form-control" name="montant" value="{{ $demande->Montant }}" disabled="true" >
                  </div>
                  
                  <div class="col-sm-6">
                    <label>Frais SSI prélever :</label>
                    <input type="text" class="form-control" name="FraisSSI" value="{{ $demande->FraisSSI }}" disabled="true">
                    <input type="hidden" class="form-control" name="montant" value="{{ $demande->MontantPayer }}" >
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>SOLDE RESTANT :</label>
                    <input type="number" step="0.00001" class="form-control" name="solde" id="solde" placeholder="Entrer le solde restant si disponible">
                
                  </div>
                  
                  <div class="col-sm-6">
                    <label>No de règlement :<i style="color: red">*</i></label>
                    <input type="text" class="form-control " name="reglement" placeholder="Entrer le numéro de règlement">
                    @if($errors->has('reglement'))
                      <p style="color: red"> {{ $errors->first('reglement') }}</p>
                    @endif
                  </div>
                </div>

                <div class="form-group">
                  <label>Période Facture :</label>
                  <input type="bday-month" class="form-control" name="periode" placeholder="Entrer la période">
                    @if($errors->has('periode'))
                      <p style="color: red"> {{ $errors->first('periode') }}</p>
                    @endif
                  </input>
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