<section>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar" style="background-color: #b3e8f7 !important;">
         <!-- User Info -->
         <div class="user-info">
            <div class="image">
                <img src="<?php echo e(asset('newcssadmin/images/user.png')); ?>" width="48" height="48" alt="User" />
            </div>
            <div class="info-container">
                <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo e(Auth::user()->prenom); ?> <?php echo e(Auth::user()->nom); ?></div>
                <div class="email"> ( <?php echo e(Auth::user()->codeperso); ?> )</div>
                <div class="btn-group user-helper-dropdown">
                    <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="<?php echo e(route('profiladmin')); ?>"><i class="material-icons">person</i>Mon Profil</a></li>
                        <li role="seperator" class="divider"></li>
                        <li><a href="<?php echo e(route('admin.logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="material-icons">input</i>Déconnexion</a>
                            <form id="logout-form" action="<?php echo e(route('admin.logout')); ?>" method="POST" style="display: none;">
                            <?php echo e(csrf_field()); ?>

                            </form>
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
                    <a href="<?php echo e(route('admin.dashboard')); ?>">
                        <i class="material-icons">home</i>
                        <span>Tableau de bord</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.index')); ?>">
                        <i class="material-icons">text_fields</i>
                        <span>Aller au SITE</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">swap_calls</i>
                        <span>Configuration</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="<?php echo e(route('coursG')); ?>">Ajouter un cours</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('nouveaufilleulG')); ?>">Ajouter un filleul</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('admin.active')); ?>">Activer compte filleul</a>
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
                            <a href="<?php echo e(route('transfertadmin')); ?>">Transfert de fond</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('prelevement')); ?>">Prélever des fonds</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('transfertadminCV')); ?>">VTE</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('prelevementCV')); ?>">VPE</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('transfertgainvirtuel')); ?>">GVTE</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('prelevementgainvirtuel')); ?>">GVPE</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('histadmin')); ?>" title="Historique de translation">H T</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('histadminclient')); ?>" title="Historique de translation Client">H T C</a>
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
                            <a href="<?php echo e(route('sonebservice')); ?>">Service SONEB</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('sbeeconventionnelservice')); ?>">Service SBEE FACTURE</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('sbeecarteservice')); ?>">Service SBEE À CARTE</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('canalservice')); ?>">Service CANAL+</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('achat$ssi')); ?>">Achat Gain</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('mtnmoovservice')); ?>">Service MTN / MOOV</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('getSRVISA')); ?>">Service VISA</a>
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
                            <a href="<?php echo e(route('retraitmtn')); ?>">Retrait MTN</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('retraitmoov')); ?>">Retrait MOOV</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('retraitgram')); ?>">Retrait MONEY GRAM</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('retraitperfect')); ?>">Retrait PERFECT MONEY</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('retraittrust')); ?>">Retrait TRUST WALLET</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('retraitwestern')); ?>">Retrait WESTERN UNION</a>
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
                            <a href="<?php echo e(route('profiladmin')); ?>">Profil</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('galerieG')); ?>">Ajouter d'image</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('evernementG')); ?>">Créer Conférence</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('listecontact')); ?>">Liste des contacts</a>
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