@extends('layouts.templaterefonteadmin')

@section('content')
<section class="content">
    <div class="container-fluid">
      <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                    ENVOYER RECU CANAL+
                    </h2>
                </div> 
                <div class="text-center">
                  @include('flash::message')
                </div>
                <div class="body">

              <!-- Formulaire de création de compte -->
              <form class="user" method="post" action="{{ route('canalrecuS') }}"> 
                {{ csrf_field() }}
              
                <div class="form-group row">
                  <div class="col-sm-12">
                  <label>Référence du recu Soneb SSI : </label>
                  <div class="form-line">
                  <input type="text" class="form-control" name="refrecu" value="{{ $demande->RefRecu }}" disabled="true" >
                  <input type="hidden" class="form-control" name="refrecu" value="{{ $demande->RefRecu }}"> 
                  <input type="hidden" class="form-control" name="CodePersoUser" value="{{ $demande->CodePersoUser }}">
                </div>
              </div>
                </div>


                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Nom :</label>
                    <div class="form-line">
                    <input type="text" class="form-control" name="nom" value="{{ $demande->Nom }}" >
                  </div>
                  </div>
                  
                  <div class="col-sm-6">
                    <label>Prénom :</label>
                    <div class="form-line">
                    <input type="text" class="form-control " name="prenom" value="{{ $demande->Prenom }}" >
                  </div>
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Mail :</label>
                    <div class="form-line">
                    <input type="text" class="form-control" name="mail" value="{{ $demande->EmailUser }}" disabled="true">

                    <input type="hidden" class="form-control" name="mail" value="{{ $demande->EmailUser }}">
                  </div>
                  </div>
                  
                  <div class="col-sm-6">
                    <label>Numéro WhatsApp :</label>
                    <div class="form-line">
                    <input type="text" class="form-control " name="WhatsApp" value="{{ $demande->TelUser }}" disabled="true">
                    <input type="hidden" class="form-control " name="WhatsApp" value="{{ $demande->TelUser }}">
                  </div>
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Numéro Carte :</label>
                    <div class="form-line">
                    <input type="text" class="form-control" name="Numerocarte" value="{{ $demande->Numerocarte }}" disabled="true">
                    <input type="hidden" class="form-control" name="Numerocarte" value="{{ $demande->Numerocarte }}">
                  </div>
                  </div>
                  
                  <div class="col-sm-6">
                    <label>Choix du Formule :</label>
                    <div class="form-line">
                    <input type="text" class="form-control" name="Choisirformule" value="{{ $demande->Choisirformule }}" disabled="true">
                    <input type="hidden" class="form-control " name="Choisirformule" value="{{ $demande->Choisirformule }}">
                  </div>
                  </div>
                </div> 

                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Libelle Service :</label>
                    <div class="form-line">
                    <input type="text" class="form-control" name="libelle" value="ABONNEMENT CANAL+" disabled="true">
                    <input type="hidden" class="form-control" name="libelle" value="ABONNEMENT CANAL+">
                    </div>
                  </div>
                  
                  <div class="col-sm-6">
                    <label>Mode de règlement :</label>
                    <div class="form-line">
                    <input type="text" class="form-control" name="modereglement" value="COMPTE AVOIR" disabled="true">
                    <input type="hidden" class="form-control" name="modereglement" value="COMPTE AVOIR">
                  </div>
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-sm-12">
                  <label>Montant Payer en $ SSI:</label>
                  <div class="form-line">
                  <input type="text" class="form-control" name="montant" value="{{ $demande->MontantPayer }}" disabled="true" >
                  
                  <input type="hidden" class="form-control" name="montant" value="{{ $demande->MontantPayer }}" >
                </div>
                </div>
                </div>

                <div class="form-group row">
                  <div class="col-sm-12">
                  <label>Durée en mois :</label>
                  <div class="form-line">
                  <input type="text" class="form-control" name="Dureenmois" value="{{ $demande->Dureenmois }}" disabled="true" >
                  <input type="hidden" class="form-control" name="Dureenmois" value="{{ $demande->Dureenmois }}" >
                </div>
                </div>
                </div>
              

                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>SOLDE RESTANT :</label>
                    <div class="form-line">
                    <input type="number" step="0.00001" class="form-control" name="solde" id="solde" placeholder="Entrer le solde restant si disponible">
                    </div>
                  </div>
                  
                  <div class="col-sm-6">
                    <label>No de règlement :<i style="color: red">*</i></label>
                    <div class="form-line">
                    <input type="text" class="form-control " name="reglement" placeholder="Entrer le numéro de règlement">
                  </div>
                    @if($errors->has('reglement'))
                      <p style="color: red"> {{ $errors->first('reglement') }}</p>
                    @endif
                  </div>
                </div> 
                <div class="form-group row">
                  <div class="col-sm-12">
                  <label>Date d'expiration :</label>
                  <div class="form-line">
                  <input type="date" class="form-control" name="dateespire" placeholder="Entrer la date d'expiration" >
                </div>
                  @if($errors->has('dateespire'))
                      <p style="color: red"> {{ $errors->first('dateespire') }}</p>
                    @endif
                  </div>
                </div>

              <button type="submit" class="btn btn-primary m-t-15 waves-effect" name="ENVOYER RECU" value="ENVOYER RECU" class="btn btn-user btn-block" id="but">ENVOYER RECU</button>
                
              </form>
              </div>
            </div>
        </div>
      </div>       

    </div>
</section> 

@endsection