<?php ini_set('max_execution_time', 320000); //12000 seconds = 20 minutes ?>
<!DOCTYPE html>
<html lang="fr">

<head>

 <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="ARIMAXE">
  <title>LA SOURCE DU SUCCES INTERNATIONAL</title>
  <link href="site_design/css/bootstrap.min.css" rel="stylesheet">
  <link href="site_design/css/animate.min.css" rel="stylesheet"> 
  <link href="site_design/css/font-awesome.min.css" rel="stylesheet">
  <link href="site_design/css/lightbox.css" rel="stylesheet">
  <link href="site_design/css/main.css" rel="stylesheet">
  <link id="css-preset" href="site_design/css/presets/preset6.css" rel="stylesheet">
  <link href="site_design/css/responsive.css" rel="stylesheet">

  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
  <![endif]-->
  
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
  
  <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">
  @yield('stylesheet')
  <style type="text/css">
    #input{
      border: 1px solid; #5ca945;
      border-radius: 10px;
    }
    #bouton{
      background-color: #5ca945; 
      color: #8c8b98
    }
  </style>

</head>

<body style="background-color:#d5d6df">
   
  <header id="home" >
    
    <div class="main-nav" >
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href=""> 
            <h1 style="color:#fff ">SSI REFONTE</h1>
            <h5 style="color:#fff; margin-top:-5px">La Source du Succès International</h5>
          </a>                    
        </div>
 
     <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">                 
            <li class="scroll active"><a href="{{ route('index') }}">Accueil</a></li>
            <li class="scroll"><a href="{{ route('dashboard') }}">Tableau de bord</a></li> 
            <li class="scroll"><a href="#">Boutique</a></li>   
            <!--li class="scroll"><a href="{{ route('boutique') }}">Boutique</a></li-->                     
            <li class="scroll">
              @if( auth()->guest())
                <a class="nav-link" href="{{ route('seconnecter') }}">Se connecter</a>
              @else
              <a class="nav-link" href="{{ route('sedeconnecterS') }}"onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Se déconnecter
              </a>
              <form id="logout-form" action="{{ route('sedeconnecterS') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
              </form>
              @endif
            </li>
             <li class="nav-item dropdown">
            <a data-toggle="dropdown" class="nav-link dropdown-toggle" href="#">
              Menu
            </a>
            <ul class="dropdown-menu extended logout" style="background-color: #5ca945">
              <div class="log-arrow-up"></div>
              <li class=" eborder-top nav-item">
                <a class="nav-link" href="{{route('galerie')}}">Galerie</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{route('evernement')}}">Evènement</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="{{route('propos')}}">À Propos de nous</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="{{route('contact')}}">Contactez-nous</a>
              </li>
            </ul>
          </li>
            
          </ul>
        </div>
      </div>
    </div><!--/#main-nav-->
    @yield('entete')
  </header><!--/#home-->

  
      @yield('content')

  <section id="contact">  
    <div style="background-color: #4f2e14;" id="" class="parallax">
      <div class="container">
        <div class="row">
          <div class="heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
            <h1 style="color : #8c8b98">Contactez-nous</h1>
            <p style="color : #8c8b98; font-size:20px">La Source du Succès International est une plate-forme basée sur des formations en éducation financière, entrepreneuriat, E-commerce et des œuvres sociales. Elle est ouverte à toute personne ayant la volonté d'entreprendre; de réaliser ses projets, ses rêves et atteindre ses objectifs de vie. Elle dispose également des services comme le payement des factures d'électricité , d'eau , réabonnement CANAL+ , achat de bien meuble ou immobilier etc.</p>
          </div>
        </div>
        <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto" style="color: #5ca945; text-decoration-style: bold;">

        @include('flash::message')

        <p>Besoin d'une information ? <br> Laissez nous un petit message et nous saurons vous aidé</p>
            
          <form method="post" action="{{ route('contactS') }}">
             {{ csrf_field() }}
          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label>Nom</label>
              <input type="text" class="form-control" placeholder="Nom" name="name" required data-validation-required-message="Veuillez entrer votre nom s'il vous plaît.">
              <p class="help-block text-danger"></p>
            </div>
          </div>
          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label>Email</label>
              <input type="email" class="form-control" placeholder="Email" name="email" required data-validation-required-message="Veuillez entrer votre adresse mail s'il vous plaît.">
              <p class="help-block text-danger"></p>
            </div>
          </div>
          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label>Numero de téléphone</label>
              <input type="tel" class="form-control" placeholder="Numero de téléphone" name="phone" required data-validation-required-message="Veuillez entrer votre numero de téléphone s'il vous plaît.">
              <p class="help-block text-danger"></p>
            </div>
          </div>
          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label>Message</label>
              <textarea rows="5" name="message" class="form-control" placeholder="Message" required data-validation-required-message="Veuillez entrer votre message s'il vous plaît."></textarea>
              <p class="help-block text-danger"></p>
            </div>
          </div>
          <br>
          <button type="submit" class="btn btn-user btn-block" id="bouton">
            <h4 style="color : #fff">Envoyer</h4>
                
          </button>
          <br> <br>
        </form>
      </div>
    </div>
           
          </div>
        </div>
      </div>
    </div>        
  </section><!--/#contact-->

  <!-- Footer -->
  @include('layouts.footer')
  
  @yield('js')

  <script type="text/javascript" src="site_design/js/jquery.js"></script>
  <script type="text/javascript" src="site_design/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
  <script type="text/javascript" src="site_design/js/jquery.inview.min.js"></script>
  <script type="text/javascript" src="site_design/js/wow.min.js"></script>
  <script type="text/javascript" src="site_design/js/mousescroll.js"></script>
  <script type="text/javascript" src="site_design/js/smoothscroll.js"></script>
  <script type="text/javascript" src="site_design/js/jquery.countTo.js"></script>
  <script type="text/javascript" src="site_design/js/lightbox.min.js"></script>
  <script type="text/javascript" src="site_design/js/main.js"></script>

  <script src="https://cdn.kkiapay.me/k.js"></script>
</body>
</html>