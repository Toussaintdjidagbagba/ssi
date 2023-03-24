<?php ini_set('max_execution_time', 320000); //12000 seconds = 20 minutes ?>
<!DOCTYPE html>
<html lang="fr">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="La plateforme qui vous conduit au sommet.">
  <meta name="author" content="SSI">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" href="{{ asset('img/logo.jpeg') }}">
  <!-- Custom fonts for this template-->


  <title>SSI</title>

  <!-- Bootstrap core CSS -->
  <link href="{{asset('vendorr/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="{{asset('vendorr/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="{{asset('css/clean-blog.min.css')}}" rel="stylesheet">
  <link href="{{asset('css/mlm.css')}}" rel="stylesheet">
  <link href="{{asset('css/mlm.min.css')}}" rel="stylesheet">
  @yield('stylesheet')

</head>

<body style=" background: url(img/hb.jpg) no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover; ">

  <!-- Entete -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <!-- <a href="navbar-brand"><img src="img/logo.jpeg" style="width: 20%; height: 20%"></a> -->
    <div class="container">
      
      <a class="navbar-brand" href="{{ route('index') }}"><img src="{{ asset('img/logo.jpeg') }}" style="height: 50px; margin-top: -12px; width: 50px" /></a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('index') }}">Accueil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">Marketing</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('boutique') }}">Boutique</a>
          </li>
          <li class="nav-item">
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

            <ul class="dropdown-menu extended logout">
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
  </nav>

  @yield('header')

          @yield('content')  

  <hr>

  <!-- Footer -->
  @include('layouts.footer')
  
  @yield('js')


  <!-- Bootstrap core JavaScript -->
  <script src="vendorr/jquery/jquery.min.js"></script>
  <script src="vendorr/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Custom scripts for this template -->
  <script src="js/clean-blog.min.js"></script>
  <script src="vendorr/jquery-easing/jquery.easing.min.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <script src="https://cdn.kkiapay.me/k.js"></script>
</body>
</html>