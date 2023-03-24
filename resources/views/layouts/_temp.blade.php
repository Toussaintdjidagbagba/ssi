<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="La plateforme qui vous conduit au sommet.">
    <meta name="author" content="SSI">
    <title>Mon compte SSI  </title>
    <!-- Favicon-->
    <link rel="icon" href="{{ asset('img/logo.jpeg') }}" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="cssdste/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="cssdste/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="cssdste/animate-css/animate.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="cssdste/css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="cssdste/css/themes/all-themes.css" rel="stylesheet" />
    
    @yield('css')
</head>

<body class="theme-green">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Patienté...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="#">{{config('app.name')}}</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    
                    <!-- Notifications -->
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">notifications</i>
                            <span class="label-count">7</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">NOTIFICATIONS</li>
                            <li class="body">
                                <ul class="menu">
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-light-green">
                                                <i class="material-icons">person_add</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4>12 filleuls inscrit</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 14 mins passé
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-cyan">
                                                <i class="material-icons">add_shopping_cart</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4>4 services</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 22 mins passé
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-purple">
                                                <i class="material-icons">settings</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4>Paramètres</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> hier
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="javascript:void(0);">Tous les notifications</a>
                            </li>
                        </ul>
                    </li>
                    
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="cssdste/images/user.png" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Admin</div>
                    <div class="email">sourcedivine@gmail.com</div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profil</a></li>
                            <li role="separator" class="divider"></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">input</i>Déconnecté</a></li>
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
                        <a href="#">
                            <i class="material-icons">home</i>
                            <span>Tableau de board</span>
                        </a>
                    </li>
                    <li >
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="material-icons">home</i>
                            <span>Tableau de board (Ancien)</span>
                        </a>
                    </li>
                    <!--li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">swap_calls</i>
                            <span>User Interface (UI)</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="../../pages/ui/tooltips-popovers.html">Tooltips & Popovers</a>
                            </li>
                        </ul>
                    </li -->
                    
                    <li class="header">Paramètres</li>
                    
                    <li><a href="#"><i class="large material-icons col-light-green">insert_chart</i><span>Rôle</span></a></li>
                    <li><a href="{{ route('NU') }}"><i class="large material-icons col-light-green">insert_chart</i><span>Utilisateurs</span></a></li>
                    <li><a href="#"><i class="large material-icons col-light-green">insert_chart</i><span>Menu</span></a></li>
                    <li><a href="#"><i class="large material-icons col-light-green">insert_chart</i><span>Pack de formation</span></a></li>
                    
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy;  {{strtoupper(strftime('%B %Y'))}} <a href="javascript:void(0);">Source du Succès International</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0.2
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->

        <!-- Right Sidebar -->
        <aside id="rightsidebar" class="right-sidebar">
            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                <!--li role="presentation" ><a href="#skins" data-toggle="tab">SKINS</a></li-->
                <li role="presentation" class="active"><a href="#settings" data-toggle="tab">PARAMETRES</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade " id="skins">
                    <ul class="demo-choose-skin">
                        <li data-theme="green" class="active">
                            <div class="green"></div>
                            <span>Green</span>
                        </li>
                        <li data-theme="light-green">
                            <div class="light-green"></div>
                            <span>Light Green</span>
                        </li>
                    </ul>
                </div>
                <div role="tabpanel" class="tab-pane fade in active in active" id="settings">
                    <div class="demo-settings">
                        <p>Paramètres</p>
                        <ul class="setting-list">
                            <li>
                                
                            </li>
                            <li>
                                
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </aside>
        <!-- #END# Right Sidebar -->
    </section>

    <section class="content">
        @yield('content')
    </section>
    
    @yield("model")
        

    @yield('js')
    
    <!-- Jquery Core Js -->
    <script src="cssdste/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="cssdste/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="cssdste/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="cssdste/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="cssdste/node-waves/waves.js"></script>

    <!-- Custom Js -->
    <script src="cssdste/js/admin.js"></script>

    <!-- Demo Js -->
    <script src="cssdste/js/demo.js"></script>
</body>

</html>
