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
                  <form class="user" method="post" action="{{ route('sonebS') }}">
                    {{ csrf_field() }}

                      <div class="form-group">
                      <label>Nom propriétaire :</label>
                      <input id="input" type="text" class="form-control nom form-control-user" placeholder="Entrez le nom propriétaire" name="nom">
                      @if($errors->has('nom'))
                        <p style="color: red"> Entrez le nom propriétaire</p>
                      @endif
                    </div>

                     <div class="form-group">
                      <label>Prénom propriétaire :</label>
                      <input id="input" type="text"  class="form-control prenom form-control-user"  placeholder="Entrez le prénom propriétaire" name="prenom">
                      @if($errors->has('prenom'))
                        <p style="color: red"> Entrez le prénom propriétaire</p>
                      @endif
                    </div>

                    <div class="form-group">
                      <label>Zone + Numéro Abonné :</label>
                      <input id="input" type="text" class="form-control zone form-control-user"  placeholder="Entrez le Zone + Numéro Abonné" name="police" >
                      @if($errors->has('police'))
                        <p style="color: red"> Saisissez votre Zone + Numéro Abonné</p>
                      @endif
                    </div>

                    <div class="form-group">
                      <label>Date de présentation :</label>
                      <input id="input" type="date" class="form-control present form-control-user"  placeholder="Entrez la date de présentation de la facture" name="presentation" >
                      @if($errors->has('presentation'))
                        <p style="color: red"> Entrez la date de présentation de la facture</p>
                      @endif
                    </div>
                    
                    <div class="form-group">
                      <label>Montant en SSI:</label>
                      <input id="input" type="number" step="0.00001" class="form-control montant form-control-user"  placeholder="Entrez le montant" name="montant" >
                      @if($errors->has('montant'))
                        <p style="color: red"> Entrez le montant</p>
                      @endif
                    </div>

                     <div class="form-group">
                      <label>Numéro WhatsApp :</label>
                      <input id="input" type="number" class="form-control num form-control-user"  placeholder="Entrez votre numéro WhatsApp pour le recu" name="numWha" >
                      @if($errors->has('tel'))
                        <p style="color: red"> Saisissez votre numéro WhatsApp</p>
                      @endif
                    </div>

                    <div class="form-group">
                      <label>Adresse mail valide :</label>
                      <input id="input" type="email" class="form-control adr form-control-user"  placeholder="Entrez une adresse mail valide pour le recu" name="mail" >
                      @if($errors->has('mail'))
                        <p style="color: red"> Saisissez votre mail valide</p>
                      @endif
                    </div>

                    <div class="form-group">
                      <input type="checkbox" class=""  placeholder="Entrez une adresse mail valide pour le recu" name="conditions" required>
                      <label><b>Règles et conditions :</b> <br> La SSI n'est pas responsable des frais de pénalité ou de coupure des factures présenter après leurs dates de présentation mais par contre elle s'engage à vous présenter vos recu par mail en 72h au plus.</label>
                    </div>
                    
                    <a class="btn btn-user btn-block validresume" href="#add" data-target="#add" data-toggle="modal" id="bouton">
                      <b style="color:#fff">Valider</b> 
                    </a> <br>
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

@section('js')
 <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">

		<div class="modal-content" id="tst">
			
		</div>

	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">
	    $(function () {
	        $(".validresume").click(function () {
	            var nom = $(".nom").val();
	            var prenom = $(".prenom").val();
	            var zone = $(".zone").val();
	            var present = $(".present").val();
	            var montant = $(".montant").val();
	            var num = $(".num").val();
	            var adr = $(".adr").val();
	            var div = document.getElementById('tst'); 
	            //console.log(nom);

                    	div.innerHTML = 
                    	'<div class="modal-header">' +
                                '   <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                '   <h4 class="modal-title" id="myModalLabel">Récapitulatif : </h4>' +
                                '</div>' +
                                '<div class="modal-body">' +
                                '   <form class="form-horizontal" method="post" action="{{ route('sonebS') }}">' +
                                '       <input type="hidden" name="_token" value="{{ csrf_token() }}" />' +
                                '       <input type="hidden" name="nom" value="'+nom+'">'+
                                '       <input type="hidden" name="prenom" value="'+prenom+'">'+
                                '       <input type="hidden" name="police" value="'+zone+'">'+
                                '       <input type="hidden" name="presentation" value="'+present+'">'+
                                '       <input type="hidden" name="montant" value="'+montant+'">'+
                                '       <input type="hidden" name="numWha" value="'+num+'">'+
                                '       <input type="hidden" name="mail" value="'+adr+'">'+
                                '      <div class="form-group">  ' +
                                '           <label class="col-sm-6" style="padding-top: 7px; margin-bottom:0px; text-align:left"> Nom propriétaire : '+ nom +' </label> ' +
                                '           <label class="col-sm-6" style="padding-top: 7px; margin-bottom:0px; text-align:left"> Prénom propriétaire : '+ prenom +' </label> ' +
                                '      </div>       ' +
                                '      <div class="form-group">  ' +
                                '           <label class="col-sm-6" style="padding-top: 7px; margin-bottom:0px; text-align:left"> Zone + Numéro Abonné : '+ zone +' </label> ' +
                                '           <label class="col-sm-6" style="padding-top: 7px; margin-bottom:0px; text-align:left"> Date de présentation : '+ present +' </label> ' +
                                '      </div>       ' +
                                '      <div class="form-group">  ' +
                                '           <label class="col-sm-6" style="padding-top: 7px; margin-bottom:0px; text-align:left"> Montant en SSI : '+ montant +' </label> ' +
                                '           <label class="col-sm-6" style="padding-top: 7px; margin-bottom:0px; text-align:left"> Numéro WhatsApp : '+ num +' </label> ' +
                                '      </div>       ' +
                                '      <div class="form-group">  ' +
                                '           <label class="col-sm-6" style="padding-top: 7px; margin-bottom:0px; text-align:left"> Adresse mail valide : '+ adr +' </label> ' +
                                '      </div>       ' +
                                '    <div class="modal-footer">   '+
                                '    <button type="submit" class="btn btn-warning btn-sm waves-effect waves-light" style="float:left; color:white;"> CONFIRMER </button>' +
                                '    <button type="bouton" data-dismiss="modal" class="btn btn-primary btn-sm waves-effect ' +
                                '    waves-light" style="float:right; color:white;">FERMER</button></div>';
	            	    
	            
	        })
	    });
	    
	</script>
    
@endsection
