<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
   <meta charset="utf-8">
   
    <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="La plateforme qui vous conduit au sommet.">
  <meta name="author" content="SSI">
  @yield('meta')
  
  <link rel="shortcut icon" href="{{ asset('img/logo.jpeg') }}"> 

  <title>Mon compte SSI (REFONTE) </title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('newrefonteadmin/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset('newrefonteadmin/plugins/node-waves/waves.css') }}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{ asset('newrefonteadmin/plugins/animate-css/animate.css') }}" rel="stylesheet" />

    <!-- Morris Chart Css-->
    <link href="{{ asset('newrefonteadmin/plugins/morrisjs/morris.css') }}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{ asset('newrefonteadmin/css/style.css') }}" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{ asset('newrefonteadmin/css/themes/all-themes.css') }}" rel="stylesheet" />

    @yield('css')
</head>

<body class="theme-green">

   <!-- container section start -->
  <section id="container" class="">

    <nav class="navbar" style="background-color: skins green !important;">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a>
            <!--logo start-->
              <a href="{{ route('index') }}" class="navbar-brand" ><img src="{{ asset('img/logo_ssi.png') }}" style="height: 60px; margin-top: -17px; width: 170px" /></a>
            <!--logo end-->
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
               <!-- Notifications -->
               <li class="dropdown">
                   @php
                        $canal = App\Providers\InterfaceServiceProvider::notif("canal");
                        $mmcn = App\Providers\InterfaceServiceProvider::notif("mtnmoovceltiisnsiag");
                        $achat = App\Providers\InterfaceServiceProvider::notif("achat");
                        $visa = App\Providers\InterfaceServiceProvider::notif("visa");
                        $sc = App\Providers\InterfaceServiceProvider::notif("sbeecarte");
                        $ssc = App\Providers\InterfaceServiceProvider::notif("sbeeconv");
                        $son = App\Providers\InterfaceServiceProvider::notif("soneb");
                        $dmtn = App\Providers\InterfaceServiceProvider::notif("mtn");
                        $dmoov = App\Providers\InterfaceServiceProvider::notif("moov");
                        $dwestern = App\Providers\InterfaceServiceProvider::notif("western");
                        $dperfect = App\Providers\InterfaceServiceProvider::notif("perfect");
                        $dgram = App\Providers\InterfaceServiceProvider::notif("gram");
                        $dtrust = App\Providers\InterfaceServiceProvider::notif("trust");
                   @endphp 
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                        <i class="material-icons">notifications</i>
                        <span class="label-count">{{ $dtrust + $dgram + $dperfect + $dwestern + $dmoov + $dmtn + $son + $ssc + $canal + $mmcn + $achat + $visa + $sc}}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">NOTIFICATIONS</li>
                        <li class="body">
                            <ul class="menu">
                            @if($canal != 0)
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="icon-circle bg-light-green">
                                        <i class="material-icons">person_add</i>
                                    </div>
                                    <div class="menu-info">
                                        <h4>S. CANAL +</h4>
                                        <p>
                                            <i class="material-icons">access_time</i> {{$canal}} en attente
                                        </p>
                                    </div>
                                </a>
                            </li>
                            @endif
                            @if($mmcn != 0)
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="icon-circle bg-cyan">
                                        <i class="material-icons">add_shopping_cart</i>
                                    </div>
                                    <div class="menu-info">
                                        <h4>S. MTN / MOOV / CELTIIS / NSIA </h4>
                                        <p>
                                            <i class="material-icons">access_time</i> {{ $mmcn }} en attente
                                        </p>
                                    </div>
                                </a>
                            </li>
                            @endif
                            @if($achat != 0)
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="icon-circle bg-cyan">
                                        <i class="material-icons">add_shopping_cart</i>
                                    </div>
                                    <div class="menu-info">
                                        <h4>S. ACHAT DE GAIN</h4>
                                        <p>
                                            <i class="material-icons">access_time</i> {{$achat}} en attente
                                        </p>
                                    </div>
                                </a>
                            </li>
                            @endif
                            @if($visa != 0)
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="icon-circle bg-orange">
                                        <i class="material-icons">mode_edit</i>
                                    </div>
                                    <div class="menu-info">
                                        <h4>S. VISA</h4>
                                        <p>
                                            <i class="material-icons">access_time</i> {{$visa}} en attente
                                        </p>
                                    </div>
                                </a>
                            </li>
                            @endif
                            @if($sc != 0)
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="icon-circle bg-orange">
                                        <i class="material-icons">mode_edit</i>
                                    </div>
                                    <div class="menu-info">
                                        <h4>S. SBEE CARTE</h4>
                                        <p>
                                            <i class="material-icons">access_time</i> {{$sc}} en attente
                                        </p>
                                    </div>
                                </a>
                            </li>
                            @endif
                            @if($ssc != 0)
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="icon-circle bg-orange">
                                        <i class="material-icons">mode_edit</i>
                                    </div>
                                    <div class="menu-info">
                                        <h4>S. SBEE FACTURE</h4>
                                        <p>
                                            <i class="material-icons">access_time</i> {{$ssc}} en attente
                                        </p>
                                    </div>
                                </a>
                            </li>
                            @endif
                            @if($son != 0)
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="icon-circle bg-orange">
                                        <i class="material-icons">mode_edit</i>
                                    </div>
                                    <div class="menu-info">
                                        <h4>S. SONEB</h4>
                                        <p>
                                            <i class="material-icons">access_time</i> {{$son}} en attente
                                        </p>
                                    </div>
                                </a>
                            </li>
                            @endif
                            @if($dmtn != 0)  
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="icon-circle bg-orange">
                                        <i class="material-icons">mode_edit</i>
                                    </div>
                                    <div class="menu-info">
                                        <h4>D. RETRAIT MTN</h4>
                                        <p>
                                            <i class="material-icons">access_time</i> {{$dmtn}} en attente
                                        </p>
                                    </div>
                                </a>
                            </li>
                            @endif
                            @if($dmoov != 0)  
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="icon-circle bg-orange">
                                        <i class="material-icons">mode_edit</i>
                                    </div>
                                    <div class="menu-info">
                                        <h4>S. RETRAIT MOOV</h4>
                                        <p>
                                            <i class="material-icons">access_time</i> {{$dmoov}} en attente
                                        </p>
                                    </div>
                                </a>
                            </li>
                            @endif
                            @if($dwestern != 0)    
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="icon-circle bg-orange">
                                        <i class="material-icons">mode_edit</i>
                                    </div>
                                    <div class="menu-info">
                                        <h4>D. RETRAIT WESTERN</h4>
                                        <p>
                                            <i class="material-icons">access_time</i> {{$dwestern}} en attente
                                        </p>
                                    </div>
                                </a>
                            </li>
                            @endif
                            @if($dperfect != 0)   
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="icon-circle bg-orange">
                                        <i class="material-icons">mode_edit</i>
                                    </div>
                                    <div class="menu-info">
                                        <h4>D. RETRAIT PERFECT MONEY</h4>
                                        <p>
                                            <i class="material-icons">access_time</i> {{$dperfect}} en attente
                                        </p>
                                    </div>
                                </a>
                            </li>
                            @endif
                            @if($dgram != 0)  
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="icon-circle bg-orange">
                                        <i class="material-icons">mode_edit</i>
                                    </div>
                                    <div class="menu-info">
                                        <h4>D. RETRAIT MONEY GRAM</h4>
                                        <p>
                                            <i class="material-icons">access_time</i> {{$dgram}} en attente
                                        </p>
                                    </div>
                                </a>
                            </li>
                            @endif
                            @if($dtrust != 0)    
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="icon-circle bg-orange">
                                        <i class="material-icons">mode_edit</i>
                                    </div>
                                    <div class="menu-info">
                                        <h4>D. RETRAIT TRUST WALLET</h4>
                                        <p>
                                            <i class="material-icons">access_time</i> {{$dtrust}} en attente
                                        </p>
                                    </div>
                                </a>
                            </li>
                            @endif
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="javascript:void(0);">S : Service ; D : Demande</a>
                        </li>
                    </ul>
                </li>
                <!-- #END# Notifications -->
              <!-- Notifications -->
              <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
              
              
                <!-- Right Sidebar -->
                <aside id="rightsidebar" class="right-sidebar">
                    <ul class="nav nav-tabs tab-nav-right" role="tablist">
                        <li role="presentation"><a href="#settings" data-toggle="tab">PARAMÈTRES</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
                           
                        </div>
                    </div>
                </aside>
                <!-- #END# Right Sidebar -->
            
              
              
            
          </ul>
        </div>
    </div>
</nav>


<section>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar" style="background-color: #b3e8f7 !important;">
         <!-- User Info -->
         <div class="user-info">
            <div class="image">
                <img src="{{ asset('newrefonteadmin/images/user.png')}}" width="48" height="48" alt="User" />
            </div>
            <div class="info-container">
                <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ session('utilisateur')->nom }} {{ session('utilisateur')->prenom }}</div>
                <div class="email"> (  )</div>
                <div class="btn-group user-helper-dropdown">
                    <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="{{ route('profiladmin') }}"><i class="material-icons">person</i>Mon Profil</a></li>
                        <li role="seperator" class="divider"></li>
                        <li><a href="{{ route('logout') }}" ><i class="material-icons">input</i>Déconnexion</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- #User Info -->
        <!-- Menu -->
        <div class="menu">
            <ul class="list">
                <li class="header">Principal</li>
                <li class="active">
                    <a href="{{ route('dashboardadm') }}">
                        <i class="material-icons">home</i>
                        <span>Tableau de bord</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('index') }}">
                        <i class="material-icons">text_fields</i>
                        <span>Aller au SITE</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">swap_calls</i>
                        <span>Configurations</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="{{ route('coursG') }}">Ajouter un cours</a>
                        </li>
                        <li>
                            <a href="{{ route('coursAg') }}">Ajouter une agence</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.active') }}">Activer compte filleul</a>
                        </li>
                        <li>
                            <a href="{{ route('listclient') }}">Listes des clients</a>
                        </li>
                        <li>
                            <a href="{{ route('listvendeur') }}">Listes des vendeurs</a>
                        </li>
                        
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">assignment</i>
                        <span>Opération MLM</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="{{ route('transfertadmin') }}">Vendre (Espèce)</a>
                        </li>
                        <li>
                            <a href="{{ route('prelevement') }}">Prélever (Espèce)</a>
                        </li>
                        <li>
                            <a href="{{ route('transfertadminCV') }}">Vendre (Commission sur Vente)</a>
                        </li>
                        <li>
                            <a href="{{ route('prelevementCV') }}">Prélever (Commission sur Vente)</a>
                        </li>
                        <li>
                            <a href="{{ route('transfertgainvirtuel') }}">Vendre (Virtuel)</a>
                        </li>
                        <li>
                            <a href="{{ route('prelevementgainvirtuel') }}">Prélever (Virtuel) </a>
                        </li>
                        <li>
                            <a href="{{ route('histadmin') }}" >Historique de translation</a>
                        </li>
                        <li>
                            <a href="{{ route('histadminclient') }}" >Historique de translation Client</a>
                        </li>
                        
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">view_list</i>
                        <span>Service SSI</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="{{ route('sonebservice') }}">Service SONEB</a>
                        </li>
                        <li>
                            <a href="{{ route('sbeeconventionnelservice') }}">Service SBEE FACTURE</a>
                        </li>
                        <li>
                            <a href="{{ route('sbeecarteservice') }}">Service SBEE À CARTE</a>
                        </li>
                        <li>
                            <a href="{{ route('canalservice') }}">Service CANAL+</a>
                        </li>
                        <li>
                            <a href="{{ route('achat$ssi') }}">Achat Gain</a>
                        </li>
                        <li>
                            <a href="{{ route('mtnmoovservice') }}">Service MTN / MOOV</a>
                        </li>
                        <li>
                            <a href="{{ route('getSRVISA') }}">Service VISA</a>
                        </li>
                        <li>
                            <a href="{{ route('nsiaservice') }}">Service NSIA Automobile</a>
                        </li>
                        <li>
                            <a href="{{ route('nsiavieservice') }}">Service NSIA GBODJEKWE</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">perm_media</i>
                        <span>Demande retrait</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="{{ route('retraitmtn') }}">Retrait MTN</a>
                        </li>
                        <li>
                            <a href="{{ route('retraitmoov') }}">Retrait MOOV</a>
                        </li>
                        <li>
                            <a href="{{ route('retraitgram') }}">Retrait MONEY GRAM</a>
                        </li>
                        <li>
                            <a href="{{ route('retraitperfect') }}">Retrait PERFECT MONEY</a>
                        </li>
                        <li>
                            <a href="{{ route('retraittrust') }}">Retrait TRUST WALLET</a>
                        </li>
                        <li>
                            <a href="{{ route('retraitwestern') }}">Retrait WESTERN UNION</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">pie_chart</i>
                        <span>Paramètres</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="{{ route('GR') }}">Rôle</a>
                        </li>
                        <li>
                            <a href="{{ route('GU') }}">Utilisateurs</a>
                        </li>
                        <li>
                            <a href="{{ route('GM') }}">Menu</a>
                        </li>
                        <li>
                            <a href="{{ route('profiladmin') }}">Profil</a>
                        </li>
                        <li>
                            <a href="{{ route('galerieG')}}">Ajouter d'image</a>
                        </li>
                        <li>
                            <a href="{{ route('evernementG') }}">Créer Conférence</a> 
                        </li>
                        <li>
                            <a href="{{ route('listecontact') }}">Liste des contacts</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- #Menu -->
        <!-- Footer -->
        <div class="legal">
            <div class="copyright">
                Copyright &copy; <a href="javascript:void(0);"> Source du Succès International <?php echo date('Y')?> </a>.
            </div>
            <div class="version">
                <b>Version: </b> 1.0.2
            </div>
        </div>
        <!-- #Footer -->
    </aside>
</section>

<!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        @include('flash::message')

        @yield('content')

    </section> 
    </section>

  </section>

  @yield("model")
   <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">

		<div class="modal-content" id="tst">
			
		</div>

	</div>
	</div>
    <script src=
"https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
    </script>
  @yield("js")

    
   <!-- Jquery Core Js -->
    <script src="{{ asset('newrefonteadmin/plugins/jquery/jquery.min.js') }}"></script>

    <!-- Bootstrap Core Js -->
    <script src="{{ asset('newrefonteadmin/plugins/bootstrap/js/bootstrap.js') }}"></script>

    <!-- Select Plugin Js -->
    <script src="{{ asset('newrefonteadmin/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="{{ asset('newrefonteadmin/plugins/jquery-slimscroll/jquery.slimscroll.js') }}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{ asset('newrefonteadmin/plugins/node-waves/waves.js') }}"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="{{ asset('newrefonteadmin/plugins/jquery-countto/jquery.countTo.js') }}"></script>

    <!-- Morris Plugin Js -->
    <script src="{{ asset('newrefonteadmin/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('newrefonteadmin/plugins/morrisjs/morris.js') }}"></script>

    <!-- ChartJs -->
    <script src="{{ asset('newrefonteadmin/plugins/chartjs/Chart.bundle.js') }}"></script>

    <!-- Flot Charts Plugin Js -->
    <script src="{{ asset('newrefonteadmin/plugins/flot-charts/jquery.flot.js') }}"></script>
    <script src="{{ asset('newrefonteadmin/plugins/flot-charts/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('newrefonteadmin/plugins/flot-charts/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('newrefonteadmin/plugins/flot-charts/jquery.flot.categories.js') }}"></script>
    <script src="{{ asset('newrefonteadmin/plugins/flot-charts/jquery.flot.time.js') }}"></script>

    <!-- Sparkline Chart Plugin Js -->
    <script src="{{ asset('newrefonteadmin/plugins/jquery-sparkline/jquery.sparkline.js') }}"></script>

    <!-- Custom Js -->
    <script src="{{ asset('newrefonteadmin/js/admin.js') }}"></script>
    <script src="{{ asset('newrefonteadmin/js/pages/index.js') }}"></script>

    <!-- Demo Js -->
    <script src="{{ asset('newrefonteadmin/js/demo.js') }}"></script>


</body>

</html>