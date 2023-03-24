@extends('layouts.template')

@section('entete')
  <div id="home-slider" class="carousel slide carousel-fade" data-ride="carousel">
      
      <div class="carousel-inner">
        <div class="item active" style="background-image: url('img/logg.png')">
          <div class="caption">
            <h1 class="animated fadeInLeftBig">Bienvenue à <span>La Source du succès International</span></h1>
            <p class="animated fadeInRightBig"></p>
            
          </div>
        </div>
        <div class="item" style="background-image: url('img/bani.png')">
          <div class="caption">
            <h1 class="animated"> Bienvenue à <span>La Source du succès International</span></h1>
            <p class="animated fadeInRightBig">‘’ La plateforme qui vous facilite la vie ‘’</p>
           
          </div>
        </div>
        <div class="item" style="background-image: url('img/ssie.png')">
          <div class="caption">
            <h1 class="animated fadeInLeftBig"> Bienvenue à <span>La Source du succès International</span> </h1>
            <p class="animated fadeInRightBig">‘’ Cela semble toujours impossible jusqu'à ce que l'on le fasse. ‘’ <br> <br> Nelson MANDELA</p>
        </div>
        </div>
        <div class="item" style="background-image: url('img/bani.png')">
          <div class="caption">
            <h1 class="animated ">Bienvenue à <span>La Source du succès International</span> </h1>
            <p class="animated fadeInRightBig">‘’ Si on me donnait la chance de tout recommencer, je choisirais le marketing de réseau. ’’ <br> <br> Bill Gate </p>
            
          </div>
        </div>
      </div>
      <a class="left-control" href="#home-slider" data-slide="prev"><i class="fa fa-angle-left"></i></a>
      <a class="right-control" href="#home-slider" data-slide="next"><i class="fa fa-angle-right"></i></a>

      <a id="tohash" href="#services"><i class="fa fa-angle-down"></i></a>

    </div>
@endsection

@section('content')
<div class="text-center">
     @include('flash::message')
</div>

<section id="services" >
    <div class="container">
      <div class="heading wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
              <div class="row">
                <div class="text-center col-sm-10 col-sm-offset-1">
                  <center> 
                    <h2  style="color: blue; font-size: xx-large;">MISSION</h2>
                  
                    <img src="img/bas1.png" style="width: 25%; height: 25%; margin-top: -50px;" >
                  </center>
                  <p  style="font-size: large;">
                    LA PLATE-FORME QUI A POUR MISSION DE VOUS SERVIR, TRANSFORMER VOTRE VIE, VOUS AIDER À LUTTER CONTRE LE CHOMAGE, LA PAUVRETÉ, VOUS CONDUIRE A LA RÉALISATION DE VOS PROJETS DE VIE, VOUS PROPULSER AU SOMMET ET S'OCCUPER DE VOTRE BIEN ÊTRE.
                    ELLE MET À LA DISPOSITION DE SES MEMBRES DES FORMATIONS EN ÉDUCATION FINANCIÈRE, DÉVELOPPEMENT PERSONNEL, SÉCURITÉ ALIMENTAIRE ET FINANCIÈRE AFIN DE LES AMENER À DEVENIR UNE AIDE POUR LA SOCIÉTÉ.
                  </p>
                </div>
              </div> 
      </div>

      <div  class="heading wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
              <div class="row">
                <div class="text-center col-sm-10 col-sm-offset-1">
                  <center> 
                    <h2  style="color: blue; font-size: xx-large;">À PROPOS DE NOUS</h2>
                  
                    <img src="img/bas1.png" style="width: 25%; height: 25%; margin-top: -50px;" >
                  </center>
                  <p style="font-size: large;">
                    LA SOURCE DU SUCCES INTERNATIONAL EST UNE PLATE-FORME BASEE SUR DES FORMATIONS EN EDUCATION FINANCIERE, ENTREPRENEURIAT, E-COMMERCE ET DES ŒUVRES SOCIALES. ELLE EST OUVERTE A TOUTE PERSONNE AYANT LA VOLONTE D’ENTREPRENDRE ; DE REALISER SES PROJETS, SES REVES ET ATTEINDRE SES OBJECTIFS DE VIE. ELLE DISPOSE EGALEMENT DES SERVICES COMME LE PAYEMENT DES FACTURES D'ELECTRICITE, D'EAU, REABONNEMENT CANAL+ , ACHAT DE BIEN MEUBLE OU IMMOBILIER ETC.
                  </p>
                </div>
              </div> 
      </div>

      <div  class="heading wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
              <div class="row">
                <div class="text-center col-sm-10 col-sm-offset-1">
                  <center> 
                    <h2  style="color: blue; font-size: xx-large;">NOS SERVICES</h2>
                  
                    <img src="img/bas1.png" style="width: 25%; height: 25%; margin-top: -50px;" >
                  </center>
                  
                </div>
              </div> 
      </div>

      <!--div class="text-center our-services">
        <div class="row">
          
          <div class="col-sm-3 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="650ms">
            <div class="service-icon">
              <a data-toggle="modal" href="#achat"> <img src="img/dollar.png" class="article_img"> </a>
            </div>
            <div class="service-info"> <br>
             <h3><a data-toggle="modal" href="#achat" style="color:#49270f; text-decoration-style: bold;"> ACHAT DE $ SSI </a></h3>
            </div>
          </div>
          

          <div class="col-sm-3 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="850ms">
            <div class="service-icon">
              <a href="{{ route('canalplus') }}"> <img src="img/canal.jpg" class="article_img"> </a>
            </div>
            <div class="service-info"> <br>
              <h3><a href="{{ route('canalplus') }}" style="color:#49270f; text-decoration-style: bold;"> Abonnement CANAL+ </a></h3>
              
            </div>
          </div>
          <div class="col-sm-3 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="750ms">
            <div class="service-icon">
              <a href="{{ route('soneb') }}"> <img src="img/soneb.jpg" class="article_img"> </a>
            </div>
            <div class="service-info"> <br>
              <h3><a href="{{ route('soneb') }}" style="color:#49270f; text-decoration-style: bold;"> Service SONEB </a></h3>
            </div>
          </div>
          
          <div class="col-sm-3 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="650ms">
            <div class="service-icon">
              <a href="{{ route('sbee') }}"> <img src="img/sbee.jpg" class="article_img"> </a>
            </div>
            <div class="service-info"> <br>
             <h3><a href="{{ route('sbee') }}" style="color:#49270f; text-decoration-style: bold;"> Service SBEE</a></h3>
              
            </div>
          </div>

          <div class="col-sm-3 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="850ms">
            <div class="service-icon">
              <a href="{{ route('moov') }}"> <img src="img/moov.png" class="article_img"> </a>
            </div>
            <div class="service-info"> <br>
              <h3><a href="{{ route('moov') }}" style="color:#49270f; text-decoration-style: bold;"> Service MOOV</a></h3>
              
            </div>
          </div>

          <div class="col-sm-3 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="750ms">
            <div class="service-icon"> 
              <a href="{{ route('mtnb') }}"> <img src="img/MTN.jpg" class="article_img"> </a>
            </div>
            <div class="service-info"> <br>
              <h3><a href="{{ route('mtnb') }}" style="color:#49270f; text-decoration-style: bold;"> Service MTN </a></h3>
            </div>
          </div>
          
          <div class="col-sm-3 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="650ms"> 
            <div class="service-icon">
              <a data-toggle="modal" href="#retrait"> <img src="img/visa.jpg" class="article_img"> 
              <?php $otp = App\Providers\InterfaceServiceProvider::sendotp();
              ?> </a>
            </div>
            <div class="service-info"> <br>
             <h3><a data-toggle="modal" href="#retrait" style="color:#49270f; text-decoration-style: bold;"> Service VISA 
             <?php $otp =  App\Providers\InterfaceServiceProvider::sendotp(); ?> </a></h3>
            </div>
          </div
          
          <div class="col-sm-3 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="950ms">
            <div class="service-icon"> 
              <a href="#"> <img src="img/echanser.jpeg" class="article_img"> </a>
            </div>
            <div class="service-info"> <br>
              <h3><a href="#" style="color:#49270f; text-decoration-style: bold;"> Service ÉCHANGE </a></h3>
            </div>
          </div>

    </div-->
    
    <div class="text-center our-services" id="divunlign">
    <div class="container">
                    <div class="row">
					
					    <div class="cardf col-md-3 col-sm-6 col-6">
						    <div class="contentf">
								<div class="imgBx">
									<a data-toggle="modal" href="{{ route('aspv')}}"> <img src="img/dollar.png" alt="" loading="lazy" > </a>
							 	</div>
								<div class="contentBx">
									<a data-toggle="modal" href="{{ route('aspv')}}"> <h4>ACHAT DE SSI</h4> </a>
								</div>
								<div class="sci">
									<a href="#"></a>
									<a href="#"></a>
									<a href="#"></a>
								</div>
						    </div>
						</div>
						
						<div class="cardf col-md-3 col-sm-6 col-6" >
						    <div class="contentf">
								<div class="imgBx">
									<a data-toggle="modal" href="{{ route('canalplus') }}"> <img src="img/canal.jpg" alt="" loading="lazy" > </a>
							 	</div>
								<div class="contentBx">
									<a data-toggle="modal" href="{{ route('canalplus') }}"> <h4>Abonnement </h4> </a>
								</div>
								<div class="sci">
									<a href="#"></a>
									<a href="#"></a>
									<a href="#"></a>
								</div>
						    </div>
						</div>
						
						<div class="cardf col-md-3 col-sm-6 col-6">
						    <div class="contentf">
								<div class="imgBx">
									<a data-toggle="modal" href="{{ route('soneb') }}"> <img src="img/soneb.jpg" alt="" loading="lazy" > </a>
							 	</div>
								<div class="contentBx">
									<a data-toggle="modal" href="{{ route('soneb') }}"> <h4>SONEB</h4> </a>
								</div>
								<div class="sci">
									<a href="#"></a>
									<a href="#"></a>
									<a href="#"></a>
								</div>
						    </div>
						</div>
						
						<div class="cardf col-md-3 col-sm-6 col-6">
						    <div class="contentf">
								<div class="imgBx">
									<a data-toggle="modal" href="{{ route('sbee') }}"> <img src="img/sbee.jpg" alt="" loading="lazy" > </a>
							 	</div>
								<div class="contentBx">
									<a data-toggle="modal" href="{{ route('sbee') }}"> <h4>SBEE</h4> </a>
								</div>
								<div class="sci">
									<a href="#"></a>
									<a href="#"></a>
									<a href="#"></a>
								</div>
						    </div>
						</div>
						
						<div class="cardf col-md-3 col-sm-6 col-6">
						    <div class="contentf">
								<div class="imgBx">
									<a data-toggle="modal" href="{{ route('moov') }}"> <img src="img/moov.png" alt="" loading="lazy" > </a>
							 	</div>
								<div class="contentBx">
									<a data-toggle="modal" href="{{ route('moov') }}"> <h4>MOOV</h4> </a>
								</div>
								<div class="sci">
									<a href="#"></a>
									<a href="#"></a>
									<a href="#"></a>
								</div>
						    </div>
						</div>
						
						<div class="cardf col-md-3 col-sm-6 col-6">
						    <div class="contentf">
								<div class="imgBx">
									<a data-toggle="modal" href="{{ route('mtnb') }}"> <img src="img/MTN.jpg" alt="" loading="lazy" > </a>
							 	</div>
								<div class="contentBx">
									<a data-toggle="modal" href="{{ route('mtnb') }}"> <h4>MTN</h4> </a>
								</div>
								<div class="sci">
									<a href="#"></a>
									<a href="#"></a>
									<a href="#"></a>
								</div>
						    </div>
						</div>
						
						<div class="cardf col-md-3 col-sm-6 col-6">
						    <div class="contentf">
								<div class="imgBx">
									<a data-toggle="modal" href="{{ route('celttisb') }}"> <img src="celtiis.svg" alt="" loading="lazy" > </a>
							 	</div>
								<div class="contentBx">
									<a data-toggle="modal" href="{{ route('celttisb') }}"> <h4>CELTIIS</h4> </a>
								</div>
								<div class="sci">
									<a href="#"></a>
									<a href="#"></a>
									<a href="#"></a>
								</div>
						    </div>
						</div>
						
						<div class="cardf col-md-3 col-sm-6 col-6">
						    <div class="contentf">
								<div class="imgBx">
									<a data-toggle="modal" href="#retrait"> <img src="img/visa.jpg" alt="" loading="lazy" > <?php $otp = App\Providers\InterfaceServiceProvider::sendotp();
                                    ?></a>
							 	</div>
								<div class="contentBx">
									<a data-toggle="modal" href="#retrait"> <h4> VISA 
                                    <?php $otp =  App\Providers\InterfaceServiceProvider::sendotp(); ?></h4> </a>
								</div>
								<div class="sci">
									<a href="#"></a>
									<a href="#"></a>
									<a href="#"></a>
								</div>
						    </div>
						</div>
						
						<div class="cardf col-md-3 col-sm-6 col-6">
						    <div class="contentf">
								<div class="imgBx">
									<a data-toggle="modal" href="#"> <img src="img/echanser.jpeg" alt="" loading="lazy" > </a>
							 	</div>
								<div class="contentBx">
									<a data-toggle="modal" href="#"> <h4>ÉCHANGE</h4> </a>
								</div>
								<div class="sci">
									<a href="#"></a>
									<a href="#"></a>
									<a href="#"></a>
								</div>
						    </div>
						</div>
						
						
						<div class="cardf col-md-3 col-sm-6 col-6">
						    <div class="contentf">
								<div class="imgBx">
									<a data-toggle="modal" href="#nsiagbodjekwe"> <img style="width:275px" src="nsia.png" alt="" loading="lazy" > </a>
							 	</div>
								<div class="contentBx">
									<a data-toggle="modal" href="#nsiagbodjekwe"> <h4>NSIA GBODJEKWE</h4> </a>
								</div>
								<div class="sci">
									<a href="#"></a>
									<a href="#"></a>
									<a href="#"></a>
								</div>
						    </div>
						</div>
						
						<div class="cardf col-md-3 col-sm-6 col-6">
						    <div class="contentf">
								<div class="imgBx">
									<a data-toggle="modal" href="{{ route('getna') }}">  <img style="width:275px" src="nsia.png" alt="" loading="lazy" > </a>
							 	</div>
								<div class="contentBx">
									<a data-toggle="modal" href="{{ route('getna') }}"> <h4>NSIA AUTOMOBILE</h4> </a>
								</div>
								<div class="sci">
									<a href="#"></a>
									<a href="#"></a>
									<a href="#"></a>
								</div>
						    </div>
						</div>
						
					</div> 
	</div>
	</div>
                

     <!-- Achat de gain -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="achat" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <form class="form-login" method="post" action="{{ route('setac') }}" style="background-image: url('img/dollar.png'); background-size: cover;">
                 {{ csrf_field() }}
              <div class="modal-header" style="text-align: left; background-color: #5ca945;">
                <h4 class="modal-title" style="color : #fff">ACHAT DE SSI</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              </div>
              <div class="modal-body" style="text-align: left;">
                <p>Veuillez entrer votre identifiant</p>
                @if( auth()->guest())
                    <input id="input" type="number" name="id" placeholder="Identifiant" pattern="[0-9]{8}" required autocomplete="off" class="form-control placeholder-no-fix"><br>
                @else
                    <input id="input" type="number" name="id" placeholder="Identifiant" pattern="[0-9]{8}" value="{{auth()->user()->codeperso}}" required autocomplete="off" class="form-control placeholder-no-fix"><br>
                @endif

                <p>Veuillez entrer le montant en SSI</p>
                <input id="input" type="number" class="form-control placeholder-no-fix"  name="montant" placeholder="Montant" step="1" min="2" max="200">
                 <br>
                
                <p>Veuillez choisir le compte à créditer</p>
                 
                 <select id="input" type="text" class="form-control placeholder-no-fix"  name="compte" >
                        <!--option value="1">Compte espèce</option-->
                        <option value="2">Compte virtuel</option>
                       
                </select> <br>
                    

                <p>Veuillez entrer la référence</p>
               <!-- Taper sur <a href="tel:*880*41*035413*0000">*880*41*035413</a>*montant# -->
                <input id="input" type="text" name="ref" placeholder="Référence" required autocomplete="off" class="form-control placeholder-no-fix">

              </div>
              <div class="modal-footer" >
                  <!--p style="color:black; text-align:center; font-size: small;">Veuillez renseigner à la suite du code qui s'affiche dans l'application téléphone le "montant" suivi de #. <br>
                  Veillez à la conformité des montants dans le formulaire et dans l'application téléphone.</p-->
                <button data-dismiss="modal" class="btn btn-default" type="button" style="background-color: #5ca945; color : #fff">Annuler</button>
                <button class="btn btn-theme" type="submit" style="background-color: #5ca945; color : #fff">VALIDER</button>
              </div>
              </form>
            </div>
          </div>
        </div>
        <!-- Achat de gain -->
        
        
     <!-- NSIA GBODJEKWE -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="nsiagbodjekwe" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <form class="form-login" method="post" action="{{ route('setng') }}" enctype="multipart/form-data" style="background-image: url('img/dollar.png'); background-size: cover;">
                 {{ csrf_field() }}
              <div class="modal-header" style="text-align: left; background-color: #5ca945;">
                <h4 class="modal-title" style="color : #fff">SOUSCRIPTION A NSIA GBODJEKWE</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              </div>
              <div class="modal-body" style="text-align: left;">
                <p>Veuillez choisir le forfait : </p>
                    <select id="input" type="number" class="form-control placeholder-no-fix"  name="forfait" >
                        <option value="1">2.2 SSI [1 100 F]</option>
                        <option value="2">4.2 SSI [2 100 F]</option>
                        <option value="3">6.2 SSI [3 100 F]</option>
                    </select> <br>
                
                <p>Votre numéro : </p>
                <input id="input" type="number" required class="form-control placeholder-no-fix"  name="num">
                 <br>
                 
                <p>Numéro de votre pièce d'identité</p>
                <input id="input" type="number" class="form-control placeholder-no-fix"  name="numcin">
                 <br>
                 
                <p>Importer votre pièce d'identité </p>
                <input id="input" type="file" name="piece" required class="form-control placeholder-no-fix"><br>
                
                <p>Nom votre père (s'il est vivant)</p>
                <input id="input" type="text" class="form-control placeholder-no-fix"  name="nomp">
                 <br>
                 
                 <p>Date de naissance de votre père (s'il est vivant)</p>
                <input id="input" type="date" class="form-control placeholder-no-fix"  name="naisp">
                 <br>
                 
                 <p>Profession père(s'il est vivant)</p>
                <input id="input" type="text" class="form-control placeholder-no-fix"  name="profp">
                 <br>
                 
                 <p>Nom votre mère (s'il est vivant)</p>
                <input id="input" type="text" class="form-control placeholder-no-fix"  name="nomm">
                 <br>
                 
                 <p>Date de naissance de votre mère (s'il est vivant)</p>
                <input id="input" type="date" class="form-control placeholder-no-fix"  name="naism">
                 <br>
                 
                 <p>Profession mère (s'il est vivant)</p>
                <input id="input" type="text" class="form-control placeholder-no-fix"  name="profm">
                 <br>
                
                
              </div>
              <div class="modal-footer" >
                  <!--p style="color:black; text-align:center; font-size: small;">Veuillez renseigner à la suite du code qui s'affiche dans l'application téléphone le "montant" suivi de #. <br>
                  Veillez à la conformité des montants dans le formulaire et dans l'application téléphone.</p-->
                <button data-dismiss="modal" class="btn btn-default" type="button" style="background-color: #5ca945; color : #fff">Annuler</button>
                <button class="btn btn-theme" type="submit" style="background-color: #5ca945; color : #fff">VALIDER</button>
              </div>
              </form>
            </div>
          </div>
        </div>
        <!-- NSIA GBODJEKWE -->

        <!-- Retrait sur carte visa -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="retrait" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <form class="form-login" method="post" action="{{ route('setSR') }}" style="background-image: url('img/dollar.png'); background-size: cover;">
                 {{ csrf_field() }}
              <div class="modal-header" style="text-align: left; background-color: #5ca945;">
                <h4 class="modal-title" style="color : #fff">Demande de retrait sur carte visa</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              </div>
              <div class="modal-body" style="text-align: left;">
                <p>Veuillez entrer votre identifiant</p>
                @if( auth()->guest())
                    <input id="input" type="number" name="id" placeholder="Identifiant" pattern="[0-9]{8}" required autocomplete="off" class="form-control placeholder-no-fix"><br>
                @else
                    <input id="input" type="number" name="id" placeholder="Identifiant" pattern="[0-9]{8}" value="{{auth()->user()->codeperso}}" required autocomplete="off" class="form-control placeholder-no-fix"><br>
                @endif
                
                <p>Intitulé de la carte :</p>
                <input id="input" type="text" name="intituler" placeholder="Carte XXXX" required autocomplete="off" class="form-control placeholder-no-fix">
                <br>
                <p>Nom et prénom de la carte :</p>
                <input id="input" type="text" name="name" placeholder="" required autocomplete="off" class="form-control placeholder-no-fix">
                <br>
                <p>Identifiant de la carte :</p>
                <input id="input" type="number" name="identifiant" placeholder="(Se trouvant derrière la carte)" required autocomplete="off" class="form-control placeholder-no-fix">
                <br>
                <p>Montant à crédité en SSI : </p>
                <input id="input" type="number" step="0.00005" max='{{$otp["max"]}}' min="5" name="montant" placeholder="Montant" pattern="[A-F][0-9]{30}" required autocomplete="off" class="form-control placeholder-no-fix">
                <br>
                <p>Renseigner votre mot de passe pour valider :</p>
                <input id="input" type="password" name="pass" required autocomplete="off" class="form-control placeholder-no-fix">

              </div>
              <div class="modal-footer" >
                  
                <button data-dismiss="modal" class="btn btn-default" type="button" style="background-color: #5ca945; color : #fff">Annuler</button>
                <button class="btn btn-theme" type="submit" style="background-color: #5ca945; color : #fff">VALIDER</button>
              </div>
              </form>
            </div>
          </div>
        </div>
        <!-- Fin Retrait sur carte visa -->

</section>

      
@endsection

@section('stylesheet')

  <style type="text/css">
  #divunlign{
    display: flex;
    flex-direction: row;
  }
  .cardf{
      
			width: 175px;
			height: 200px;
			padding: 30px 30px;
			margin: 40px;
			background: #d5d6df;
			box-shadow: 0.6em 0.6em 1.2em #d2dce9, 
						-0.5em -0.5em 1em #ffffff;
			border-radius: 20px;
		}

		.cardf .contentf{
			display: flex;
			justify-content: center;
			align-items: center;
			flex-direction: column;
		}

		.cardf .contentf .imgBx{
			width: 105px;
			height: 105px;
			border-radius: 5%; 
			position: relative;
			margin-bottom: 2px;
			overflow: hidden;
		}

		.cardf .contentf .imgBx img{
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			object-fit: cover;
		}

		.cardf .contentf .contentBx h4{
			color: #d29f13;
			font-size: 1.0em;
			font-weight: bold;
			text-align: center;
			letter-spacing: 1px;

		}

		.cardf .contentf .contentBx h5{
			color: #d29f13;
			font-size: 1.2em;
			font-weight: bold;
			text-align: center;
		}

		.cardf .contentf .sci{
			margin-top: 20px;

		}

		.cardf .contentf .sci a{
			text-decoration: none;
			color: #6C758F;
			font-size: 30px;
			margin: 10px;
			transition: 0.9s;
		}

		.cardf .contentf .sci a:hover{
			color: #d29f13;
		}
    .article
    {
        width: 250px;
        height: 250px;
        background-color: #F7F8F9 !important;
    }

    .article_img
    {
        width: 105px;
        height: 105px;
        left:50%;
        background-color: #F9F1F3 !important;
    }

  </style>

@endsection