<!--sidebar start-->

<aside>
  <div id="sidebar" class="nav-collapse " >
    <!-- sidebar menu start-->
    <ul class="sidebar-menu" > 
      <li class="active">
        <a class="" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Tableau de bord</span>
        </a>
      </li> 

      <li class="sub-menu">
        <a href="{{ route('index') }}" class="">
            <i class="fas fa-globe"></i>
            <span>Aller au SITE</span>
        </a>
      </li>

      <li class="sub-menu">
        <a href="javascript:;" class="">
            <i class="fas fa-fw fa-cog"></i>
            <span>Formation</span>
            <span class="menu-arrow arrow_carrot-right"></span>
        </a>
        <ul class="sub">
            <li><a class="" href="{{ route('regle') }}">Règle du MLM</a></li>
            <li><a class="" href="{{ route('formation')}}">Mes formations</a></li>
            
        </ul>
      </li>

        

        <li class="sub-menu">
            <a class="" href="javascript:;">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Porte-feuille</span>
                <span class="menu-arrow arrow_carrot-right"></span>
            </a>
            <ul class="sub">
                <li><a class="" href="{{ route('gains') }}">Mes Gains</a></li>
                <li><a class="" href="{{ route('transfert')}}">Transfert de fond</a></li>
                <li><a class="" href="{{ route('vte')}}">Transfert C.V vers Virtuel</a></li>
				<li><a class="" href="{{ route('cte')}}">Transfert C.V vers Espèce</a></li>
				<?php 
				    setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
                    date_default_timezone_set('Africa/Porto-Novo');
                    
                  $date1 = strftime('%d-%m-%Y');
                  
                  $date2 = "25".strftime('-%m-%Y');
                  $moisprochain = strftime('%m');
                  $date3 = "1"."-".$moisprochain."-".strftime('%Y');
                  $timestamp1 = strtotime($date1);
                  $timestamp2 = strtotime($date2);
                  $timestamp3 = strtotime($date3); 
                  //@if ($timestamp1 >= $timestamp2 || $timestamp1 == $timestamp3) 
                  //@endif ?>
                  <li><a href="{{ route('retrait')}}">Retrait de fond</a></li> 
                  <li><a href="{{ route('histclient')}}">Historique</a></li> 
                
            </ul>
        </li>
       <li class="sub-menu">
        <a href="javascript:;" class="">
            <i class="icon_cog"></i>
            <span>Paramètres</span>
            <span class="menu-arrow arrow_carrot-right"></span>
        </a>
        <ul class="sub">
          <li><a class="" href="{{ route('profil') }}">Profil</a></li>
          <li>
            <a href="{{ route('admin.logout') }}"onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              </i> Déconnexion
            </a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
              {{ csrf_field() }}
            </form>
          </li>
          <!-- <li><a class="" href="#"><span>Gestion des droits</span></a></li> -->
        </ul>
      </li>

    </ul>
    <!-- sidebar menu end-->
  </div>
</aside>
<!--sidebar end-->
