<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="La plateforme qui vous conduit au sommet.">
  <meta name="author" content="SSI">
  
  <link rel="shortcut icon" href="{{ asset('img/logo.jpeg') }}">

  <title>Mon Compte SSI (REFONTE)</title>

      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <!-- Google font-->
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
      <!-- Required Fremwork -->
      <link rel="stylesheet" type="text/css" href="newrefonte/assets/css/bootstrap/css/bootstrap.min.css">
      <!-- themify-icons line icon -->
      <link rel="stylesheet" type="text/css" href="newrefonte/assets/icon/themify-icons/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="newrefonte/assets/icon/font-awesome/css/font-awesome.min.css">
      <!-- ico font -->
      <link rel="stylesheet" type="text/css" href="newrefonte/assets/icon/icofont/css/icofont.css">
      <!-- Style.css -->
      <link rel="stylesheet" type="text/css" href="newrefonte/assets/css/style.css">
      <link rel="stylesheet" type="text/css" href="newrefonte/assets/css/jquery.mCustomScrollbar.css">

  @yield('css')

  <style type="text/css">
    .alert-success {
      background-color: #dff8e3;
      border-color: #4CAF50;
      color: #4CAF50;
      border-radius: 50px;
    }
    #signataire{
      height: 100px;
      width: 150px;
      padding : 2px;
      margin-left: 0px;
      margin-top: 0px;"
    }
  </style>


</head>

<body>
  <div class="fixed-button">
    <a data-toggle="modal" data-target="#abn" target="_blank" style="color: white" class="btn btn-md btn-primary">
      <i class="fa fa-shopping-cart" aria-hidden="true"></i> Passer au pack supérieur
    </a>
    </div>
  <!-- Pre-loader start -->
    <div class="theme-loader">
        <div class="loader-track">
            <div class="loader-bar"></div>
        </div>
    </div>



    <!-- Pre-loader end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">

            <nav class="navbar header-navbar pcoded-header">
               <div class="navbar-wrapper">
                   <div class="navbar-logo">
                       <a class="mobile-menu" id="mobile-collapse" href="#!">
                           <i class="ti-menu"></i>
                       </a>
                       <div class="mobile-search">
                           <div class="header-search">
                               <div class="main-search morphsearch-search">
                                   <div class="input-group">
                                       <span class="input-group-addon search-close"><i class="ti-close"></i></span>
                                       <input type="text" class="form-control" placeholder="Enter Keyword">
                                       <span class="input-group-addon search-btn"><i class="ti-search"></i></span>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <a href="{{ route('index') }}">
                           <img class="img-fluid" src="{{ asset('newrefonte/assets/images/titre.png') }}" style="height: 50px; margin-top: 0px; width: 160px" alt="" />
                       </a>
                       <a class="mobile-options">
                           <i class="ti-more"></i>
                       </a>
                   </div>

                   <div class="navbar-container container-fluid">
                       <ul class="nav-left">
                           <li>
                               <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
                           </li>
                           <li class="header-search">
                               <div class="main-search morphsearch-search">
                                   <div class="input-group">
                                       <span class="input-group-addon search-close"><i class="ti-close"></i></span>
                                       <input type="text" class="form-control">
                                       <span class="input-group-addon search-btn"><i class="ti-search"></i></span>
                                   </div>
                               </div>
                           </li>
                           <li>
                               <a href="#!" onclick="javascript:toggleFullScreen()">
                                   <i class="ti-fullscreen"></i>
                               </a>
                           </li>
                       </ul>
                       <ul class="nav-right">
                           <li class="header-notification">
                               <a href="#!">
                                   <i class="ti-bell"></i>
                                   <span class="badge bg-c-pink"></span>
                               </a>
                               <ul class="show-notification">
                                   <li>
                                       <h6>Notifications</h6>
                                       <label class="label label-danger">Nouveau</label>
                                   </li>
                                   <?php $hists =  App\Providers\InterfaceServiceProvider::AllHist()?>
                                    @foreach($hists as $hist)
                                      <li>
                                       <div class="media">
                                           <img class="d-flex align-self-center img-radius" src="newrefonte/assets/images/defaut.png" >
                                           <div class="media-body">
                                               <p class="notification-msg">{{ $hist->libelle }}</p>
                                               <span class="notification-time">0 minutes passé</span>
                                           </div>
                                       </div>
                                      </li>
                                    @endforeach
                                   
                                   <li>
                                    <div class="text-center">
                                        <a style="padding-bottom: 10px; padding-right: 20px; padding-left: 20px; padding-top: 10px; color: green" href="{{ route('histclient')}}" class="btn btn-outline-primary btn-round btn-sm">Voir tout</a>
                                    </div>
                                   </li>
                                   
                               </ul>
                           </li>
                           
                           <li class="user-profile header-notification">
                               <a href="#!">
                                   <img src="newrefonte/assets/images/defaut.png" class="img-radius" style="border-color: white" alt="User-Profile-Image">
                                   <span>{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</span>
                                   <i class="ti-angle-down"></i>
                               </a>
                               <ul class="show-notification profile-notification">
                                   <li>
                                       Identifiant : {{ Auth::user()->codeperso }}
                                   </li>                                  
                                   <li>
                                       <a href="{{ route('profil') }}">
                                           <i class="ti-user"></i> Profil
                                       </a>
                                   </li>
                                   
                                   <!--li>
                                       <a href="auth-lock-screen.html">
                                           <i class="ti-lock"></i> Verrouillé
                                       </a>
                                   </li-->
                                   <li>
                                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                      {{ csrf_field() }}
                                    </form>
                                    <a href="{{ route('admin.logout') }}"onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="ti-layout-sidebar-left"></i> Déconnexion
                                    </a>
                                    
                                   </li>
                               </ul>
                           </li>
                       </ul>
                   </div>
               </div>
           </nav>
            <div class="pcoded-main-container" style="background-color: #e0f2f8">
                <div class="pcoded-wrapper">
                    <nav class="pcoded-navbar" >
                        <div class="sidebar_toggle" ><a href="#"><i class="icon-close icons"></i></a></div>
                        <div class="pcoded-inner-navbar main-menu" style="background-color: #b3e5fb">
                            
                            <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation">Principal</div>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="active">
                                    <a href="{{ route('dashboard') }}">
                                        <span class="pcoded-micon"><i class="ti-home"></i><b>T</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.dash.main">Tableau de bord</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('index') }}">
                                        <span class="pcoded-micon"><i class="ti-home"></i><b>T</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.dash.main">Site Web</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('formation') }}">
                                        <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i><b>T</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.dash.main">Mes formations</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                            </ul>

                            <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation">Nature</div>
                            <ul class="pcoded-item pcoded-left-item">
                                
                                <li>
                                    <a href="{{ route('nature') }}">
                                        <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i><b>T</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.dash.main">Gain en Nature</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('mnature') }}">
                                        <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i><b>T</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.dash.main">Gain en Nature Gagné</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                            </ul>


                            <div class="pcoded-navigatio-lavel" data-i18n="nav.category.forms">Porte-feuille</div>
                            <ul class="pcoded-item pcoded-left-item">
                                <li>
                                    <a href="{{ route('gains') }}">
                                        <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Mes Gains</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('transfert')}}">
                                        <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Transfert de fond</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('vte')}}">
                                        <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Transfert C.V vers Virtuel</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('cte')}}">
                                        <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Transfert C.V vers Espèce</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('retrait')}}">
                                        <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Retrait de fond</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('histclient')}}">
                                        <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Historique</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                    @include('flash::message')
                    @yield('content')
                    
                </div>
            </div>
        </div>




<div class="modal fade" id="abn" tabindex="-1" role="dialog" aria-labelledby="abn" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                          <div class="modal-content">
                                                            <div class="modal-header">
                                                              <h5 class="modal-title" id="abn">Pack</h5>
                                                              
                                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                              </button>
                                                            </div>
                                                            <div class="modal-body">
                                                             
                                                              <form class="user" method="post" action="{{ route('PackAbonnement') }}">
                                                                {{ csrf_field() }}
                                                              
                                                                   <div class="form-group">
                                                                      <label>Pack actuel : </label>
                                                                      <input type="text" disabled="true" class="form-control"  value="{{ App\Providers\InterfaceServiceProvider::libellePack(Auth::user()->Pack) }}">
                                                                      
                                                                   </div>

                                                                  <div class="form-group">
                                                                   <label>Pack : </label>
                                                                   <select name="packnew" type="text" class="form-control">
                                                                    <?php $pack =  App\Providers\InterfaceServiceProvider::allPacks()?>
                                                                     @foreach($pack as $pa)
                                                                        <option value="{{ $pa->id }}">{{ $pa->libelle }} : {{ $pa->valeur }} $ SSI</option>
                                                                      @endforeach
                                                                   </select>
                                                                  </div>

                                                                <input type="submit" name="CHANGER" value="CHANGER" class="btn btn-primary btn-block" style="background-color: #ffc961" />
                                                                
                                                              </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">FERMER</button>
                                                              
                                                            </div>
                                                          </div>
                                                        </div>
                                                      </div>





 
  <!-- container section start -->
<!-- Required Jquery -->
<script type="text/javascript" src="newrefonte/assets/js/jquery/jquery.min.js"></script>
<script type="text/javascript" src="newrefonte/assets/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="newrefonte/assets/js/popper.js/popper.min.js"></script>
<script type="text/javascript" src="newrefonte/assets/js/bootstrap/js/bootstrap.min.js"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="newrefonte/assets/js/jquery-slimscroll/jquery.slimscroll.js"></script>
<!-- modernizr js -->
<script type="text/javascript" src="newrefonte/assets/js/modernizr/modernizr.js"></script>
<!-- am chart -->
<script src="newrefonte/assets/pages/widget/amchart/amcharts.min.js"></script>
<script src="newrefonte/assets/pages/widget/amchart/serial.min.js"></script>
<!-- Chart js -->
<script type="text/javascript" src="newrefonte/assets/js/chart.js/Chart.js"></script>
<!-- Todo js -->
<script type="text/javascript " src="newrefonte/assets/pages/todo/todo.js "></script>
<!-- Custom js -->
<script type="text/javascript" src="newrefonte/assets/pages/dashboard/custom-dashboard.min.js"></script>
<script type="text/javascript" src="newrefonte/assets/js/script.js"></script>
<script type="text/javascript " src="newrefonte/assets/js/SmoothScroll.js"></script>
<script src="newrefonte/assets/js/pcoded.min.js"></script>
<script src="newrefonte/assets/js/vartical-demo.js"></script>
<script src="newrefonte/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
</body>

</html>