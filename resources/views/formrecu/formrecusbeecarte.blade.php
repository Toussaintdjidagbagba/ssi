@extends('layouts.templaterefonteadmin')

@section('content')
<section class="content">
    <div class="container-fluid">
      <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                    ENVOYER RECU SBEE : Achat de crédit CARTE
                    </h2>
                </div> 
                <div class="text-center">
                  @include('flash::message')
                </div>
                <div class="body">

              <!-- Formulaire de création de compte -->
              <form class="user" method="post" action="{{ route('sbeecarterecuS') }}"> 
                {{ csrf_field() }}
              
                <div class="form-group row">
                  <div class="col-sm-12">
                  <label>Référence du recu SBEE CONVENTIONNEL SSI : </label>
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
                    <input type="text" class="form-control" name="nom" value="{{ $demande->Nom }}" disabled="true">
                    <input type="hidden" class="form-control" name="nom" value="{{ $demande->Nom }}">
                     </div>
                  </div>
                  
                  <div class="col-sm-6">
                    <label>Prénom :</label>
                    <div class="form-line">
                    <input type="text" class="form-control " name="prenom" value="{{ $demande->Prenom }}" disabled="true">
                    <input type="hidden" class="form-control " name="prenom" value="{{ $demande->Prenom }}">
                  </div>
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Mail :</label>
                    <div class="form-line">
                    <input type="text" class="form-control" name="mail" value="{{ $demande->Email }}" disabled="true">

                    <input type="hidden" class="form-control" name="mail" value="{{ $demande->Email }}">
                  </div>
                  </div>
                  
                  <div class="col-sm-6">
                    <label>Numéro WhatsApp :</label>
                    <div class="form-line">
                    <input type="text" class="form-control " name="WhatsApp" value="{{ $demande->WhatsApp }}" disabled="true">
                    <input type="hidden" class="form-control " name="WhatsApp" value="{{ $demande->WhatsApp }}">
                  </div>
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-sm-12">
                    <label>Référence du compteur :</label>
                    <div class="form-line">
                    <input type="text" class="form-control" name="police" value="{{ $demande->Police }}" disabled="true">
                    <input type="hidden" class="form-control" name="police" value="{{ $demande->Police }}">
                    </div>
                  </div>
                </div> 

                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Libelle Service :</label>
                    <div class="form-line">
                    <input type="text" class="form-control" name="libelle" value="SBEE : CREDITS" disabled="true">
                    <input type="hidden" class="form-control" name="libelle" value="SBEE : CREDIT">
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
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Montant Crédit Carte SBEE en $ SSI:</label>
                    <div class="form-line">
                    <input type="text" class="form-control" name="montant" value="{{ $demande->Montant }}" disabled="true" >
                  </div>
                  </div>
                  
                  <div class="col-sm-6">
                    <label>Frais SSI prélever :</label>
                    <div class="form-line">
                    <input type="text" class="form-control" name="FraisSSI" value="{{ $demande->FraisSSI }}" disabled="true">
                    <input type="hidden" class="form-control" name="montant" value="{{ $demande->MontantPayer }}" >
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
                  <label>Code STS :</label>
                  <div class="form-line">
                  <input type="bday-month" class="form-control" name="sts" placeholder="Entrer le code STS">
                </div>
                    @if($errors->has('sts'))
                      <p style="color: red"> {{ $errors->first('sts') }}</p>
                    @endif
                  </div> 
                </div>

                <div class="form-group row">
                  <div class="col-sm-12">
                  <label>Kwh :</label>
                  <div class="form-line">
                  <input type="bday-month" class="form-control" name="kwh" placeholder="Entrer la puissance du crédit acheté">
                </div>
                    @if($errors->has('kwh'))
                      <p style="color: red"> {{ $errors->first('kwh') }}</p>
                    @endif
                  </div>
                </div>
                
                <div class="form-group row">
                  <div class="col-sm-12">
                  <label>Entretien :</label>
                  <div class="form-line">
                  <input type="bday-month" class="form-control" name="entretien" placeholder="Entrer le coût de l'entretien s'il existe">
                </div>
                    @if($errors->has('entretien'))
                      <p style="color: red"> {{ $errors->first('entretien') }}</p>
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