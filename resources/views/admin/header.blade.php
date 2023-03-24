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
                                        <h4>SERVICE CANAL +</h4>
                                        <p>
                                            <i class="material-icons">access_time</i> 14 mins ago
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
                                        <h4>SERVICE MTN ET MOOV</h4>
                                        <p>
                                            <i class="material-icons">access_time</i> 22 mins ago
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
                                        <h4>SERVICE ACHAT ET GAIN</h4>
                                        <p>
                                            <i class="material-icons">access_time</i> 22 mins ago
                                        </p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="icon-circle bg-orange">
                                        <i class="material-icons">mode_edit</i>
                                    </div>
                                    <div class="menu-info">
                                        <h4>SERVICE VISA</h4>
                                        <p>
                                            <i class="material-icons">access_time</i> 2 hours ago
                                        </p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="icon-circle bg-orange">
                                        <i class="material-icons">mode_edit</i>
                                    </div>
                                    <div class="menu-info">
                                        <h4>SERVICE SBEE CARTE</h4>
                                        <p>
                                            <i class="material-icons">access_time</i> 2 hours ago
                                        </p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="icon-circle bg-orange">
                                        <i class="material-icons">mode_edit</i>
                                    </div>
                                    <div class="menu-info">
                                        <h4>SERVICE SBEE FACTURE</h4>
                                        <p>
                                            <i class="material-icons">access_time</i> 2 hours ago
                                        </p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="icon-circle bg-orange">
                                        <i class="material-icons">mode_edit</i>
                                    </div>
                                    <div class="menu-info">
                                        <h4>SERVICE SONEB</h4>
                                        <p>
                                            <i class="material-icons">access_time</i> 2 hours ago
                                        </p>
                                    </div>
                                </a>
                            </li>
                                
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="javascript:void(0);">View All Notifications</a>
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
            
              
              
            <!-- <li class="dropdown">
                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                {{ Auth::user()->prenom }} {{ Auth::user()->nom }} ( {{ Auth::user()->codeperso }} )
                <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li class="header">PROFIL</li>
                    <div class="log-arrow-up"></div>
                    <li class="eborder-top">
                      <a href="{{ route('profiladmin') }}"><i class="icon_profile"></i> Mon Profil</a>
                    </li>
                    
                    <li>
                      <a href="{{ route('admin.logout') }}"onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="icon_key_alt"></i> Déconnexion
                      </a>
                      <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                      </form>
                    </li>
                </ul>
            </li> -->
          </ul>
        </div>
    </div>
</nav>
