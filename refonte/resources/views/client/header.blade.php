<header class="header dark-bg">
  <div class="toggle-nav">
    <div class="icon-reorder tooltips" data-original-title="Menu" data-placement="bottom"><i class="icon_menu"></i></div>
  </div>
 
  <!--logo start-->
  <a href="{{ route('index') }}" class="logo"><img src="{{ asset('img/logo.jpeg') }}" style="height: 50px; margin-top: -12px; width: 50px" /></a>
  <!--logo end-->

  <div class="nav search-row" id="top_menu">
    <!--  search form start -->
    <!--<ul class="nav top-menu">
      <li>
        <form class="navbar-form">
          <input class="form-control" placeholder="Rechercher..." type="text">
        </form>
      </li>
    </ul>-->
    <!--  search form end -->
  </div>

  <div class="top-nav notification-row">
    <!-- notificatoin dropdown start-->
    <ul class="nav pull-right top-menu">

      <!-- user login dropdown start-->
      <li class="dropdown">
        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
            <span class="profile-ava">

            </span>
            <span class="username"> {{ Auth::user()->prenom }} {{ Auth::user()->nom }} ( {{ Auth::user()->codeperso }} ) </span>
            <b class="caret"></b>
        </a>
        <ul class="dropdown-menu extended logout">
          <div class="log-arrow-up"></div>
          <li class="eborder-top">
            <a href="{{ route('profil') }}"><i class="icon_profile"></i> Mon Profil</a>
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
      </li>
      <!-- user login dropdown end -->

    </ul>
    <!-- notificatoin dropdown end-->
  </div>
</header>
<!--header end-->
