@extends('layouts.template')

@section('css') 
  <link href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  
@endsection

 
@section('content') 

<section id="services" >

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        
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
                    @include('flash::message')
                  </div>
                  <div class="text-center">

                    <h1 style="color: #4f2e14; font-size: x-large;" class="h4 text-gray-900 mb-4">Paiement facture Société National des Eaux du Bénin </h1> <br>
                  </div>
                  <form class="user" style="border: 0.5px solid gray; padding: 20px" method="post" action="{{ route('sonebS') }}">
                    {{ csrf_field() }}

                      <div class="form-group">
                      <label>Nom propriétaire :</label>
                      <input id="input" type="text" class="form-control form-control-user" placeholder="Entrez le nom propriétaire" name="nom">
                      @if($errors->has('nom'))
                        <p style="color: red"> Entrez le nom propriétaire</p>
                      @endif
                    </div>

                     <div class="form-group">
                      <label>Prénom propriétaire :</label>
                      <input id="input" type="text"  class="form-control form-control-user"  placeholder="Entrez le prénom propriétaire" name="prenom">
                      @if($errors->has('prenom'))
                        <p style="color: red"> Entrez le prénom propriétaire</p>
                      @endif
                    </div>

                    <div class="form-group">
                      <label>Numero de police du compteur :</label>
                      <input id="input" type="text" class="form-control form-control-user"  placeholder="Entrez le numéro de police du compteur" name="police" >
                      @if($errors->has('police'))
                        <p style="color: red"> Saisissez votre numéro de police du compteur</p>
                      @endif
                    </div>

                    <div class="form-group">
                      <label>Date de présentation :</label>
                      <input id="input" type="date" class="form-control form-control-user"  placeholder="Entrez la date de présentation de la facture" name="presentation" >
                      @if($errors->has('presentation'))
                        <p style="color: red"> Entrez la date de présentation de la facture</p>
                      @endif
                    </div>
                    
                    <div class="form-group">
                      <label>Montant en $ SSI:</label>
                      <input id="input" type="number" step="0.00001" class="form-control form-control-user"  placeholder="Entrez le montant" name="montant" >
                      @if($errors->has('montant'))
                        <p style="color: red"> Entrez le montant</p>
                      @endif
                    </div>

                     <div class="form-group">
                      <label>Numéro WhatsApp :</label>
                      <input id="input" type="number" class="form-control form-control-user"  placeholder="Entrez votre numéro WhatsApp pour le recu" name="numWha" >
                      @if($errors->has('tel'))
                        <p style="color: red"> Saisissez votre numéro WhatsApp</p>
                      @endif
                    </div>

                    <div class="form-group">
                      <label>Adresse mail valide :</label>
                      <input id="input" type="email" class="form-control form-control-user"  placeholder="Entrez une adresse mail valide pour le recu" name="mail" >
                      @if($errors->has('mail'))
                        <p style="color: red"> Saisissez votre mail valide</p>
                      @endif
                    </div>

                    <div class="form-group">
                      <input type="checkbox" class=""  placeholder="Entrez une adresse mail valide pour le recu" name="conditions" required>
                      <label><b>Règles et conditions :</b> <br> La SSI n'est pas responsable des frais de pénalité ou de coupure des factures présenter après leurs dates de présentation mais par contre elle s'engage à vous présenter vos recu par mail en 72h au plus.</label>
                    </div>
                    
                    
                    <button type="submit" class="btn btn-user btn-block" id="bouton">
                      <b style="color:#fff">Valider</b>
                    </button> <br>

                    
                  
                  </form>
                 
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

</section>
@endsection