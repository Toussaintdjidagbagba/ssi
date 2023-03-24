<?php $__env->startSection('meta'); ?>
    <meta http-equiv="refresh" content="15">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<section class="content">
    <div class="container-fluid">
        
        <!-- Widgets -->
        <div class="row clearfix">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="<?php echo e(route('canalservice')); ?>">
                <div class="info-box bg-pink hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">SERVICE CANAL+</div>
                        <div> <b> <?php echo e($ncanals); ?> en attente </b></div>
                    </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="<?php echo e(route('mtnmoovservice')); ?>">
                <div class="info-box bg-cyan hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">SERVICE MTN et MOOV</div>
                        <div> <b> <?php echo e($nmtnmoovs); ?> en attente </b></div>
                    </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="<?php echo e(route('achat$ssi')); ?>">
                <div class="info-box bg-light-green hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">SERVICE Achat de gain</div>
                        <div> <b> <?php echo e($nachats); ?> en attente </b></div>
                    </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="<?php echo e(route('getSRVISA')); ?>">
                <div class="info-box bg-orange hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">SERVICE VISA</div>
                        <div> <b> <?php echo e($nvisas); ?> en attente </b></div>
                    </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="<?php echo e(route('sbeecarteservice')); ?>">
                <div class="info-box bg-pink hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">SERVICE SBEE CARTE</div>
                        <div> <b> <?php echo e($nbeecartes); ?> en attente </b></div>
                    </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="<?php echo e(route('sbeeconventionnelservice')); ?>">
                <div class="info-box bg-cyan hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">SERVICE SBEE FACTURE</div>
                        <div> <b> <?php echo e($nbeeconventiels); ?> en attente </b></div>
                    </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="<?php echo e(route('sonebservice')); ?>">
                <div class="info-box bg-light-green hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">SERVICE SONEB</div>
                        <div> <b> <?php echo e($nsonebs); ?> en attente </b></div>
                    </div>
                </div>
              </a>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="<?php echo e(route('sbeeconventionnelservice')); ?>">
                <div class="info-box bg-pink hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">DEMANDE RETRAIT MTN</div>
                        <div> <b> <?php echo e($nbeeconventiels); ?> en attente </b></div>
                    </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="<?php echo e(route('retraitmoov')); ?>">
                <div class="info-box bg-cyan hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">DEMANDE RETRAIT MOOV</div>
                        <div> <b> <?php echo e($nmoovs); ?> en attente </b></div>
                    </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="<?php echo e(route('retraitwestern')); ?>">
                <div class="info-box bg-light-green hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">DEMANDE RETRAIT WESTERN UNION</div>
                        <div> <b> <?php echo e($nwesterns); ?> en attente </b></div>
                    </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="<?php echo e(route('retraitperfect')); ?>">
                <div class="info-box bg-orange hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">DEMANDE RETRAIT PERFECT MONEY</div>
                        <div> <b> <?php echo e($nperfects); ?> en attente </b></div>
                    </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="<?php echo e(route('retraitgram')); ?>">
                <div class="info-box bg-pink hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">DEMANDE RETRAIT MONEY GRAM</div>
                        <div> <b> <?php echo e($ngrams); ?> en attente </b></div>
                    </div>
                </div>
              </a>
            </div>



            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="<?php echo e(route('retraittrust')); ?>">
                <div class="info-box bg-pink hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">DEMANDE RETRAIT TRUST WALLET</div>
                        <div> <b> <?php echo e($ntrusts); ?> en attente </b></div>
                    </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="#">
                <div class="info-box bg-cyan hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">GAIN RECOLTER</div>
                        <div> <b> <?php echo e($compterecu[0]->compteavoirrecu); ?> $ SSI </b></div>
                    </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="#">
                <div class="info-box bg-light-green hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">GAIN DEBITER</div>
                        <div> <b> <?php echo e($compterecu[0]->compteavoirsortant); ?> $ SSI  </b></div>
                    </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="#">
                <div class="info-box bg-orange hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">Commission sur vente</div>
                        <div> <b> 0 $ SSI </b></div>
                    </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="<?php echo e(route('listclient')); ?>">
                <div class="info-box bg-pink hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">NOMBRE DE CLIENT</div>
                        <div> <b> <?php echo e($all); ?></b></div>
                    </div>
                </div>
              </a>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="<?php echo e(route('nouveaufilleulG')); ?>">
                <div class="info-box bg-pink hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">Ajouter un filleul</div>
                        <div> <b> <?php echo e($filleuladmin[0]->nombredefilleul); ?> </b></div>
                    </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="<?php echo e(route('mtnmoovservice')); ?>">
                <div class="info-box bg-cyan hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">SERVICE MTN et MOOV</div>
                        <div> <b> <?php echo e($nmtnmoovs); ?> en attente </b></div>
                    </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="<?php echo e(route('achat$ssi')); ?>">
                <div class="info-box bg-light-green hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">SERVICE Achat de gain</div>
                        <div> <b> <?php echo e($nachats); ?> en attente </b></div>
                    </div>
                </div>
              </a>
            </div>


        </div>


        <!-- Hover Rows -->
        <!-- <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                      <h2>
                        Liste des filleuls utilisant le code du système
                      </h2>
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nom & Prénom Filleul</th>
                                    <th>Code de parrainage du Filleul</th>
                                    <th>Identifiant du Filleul</th>
                                    <th>Statut</th>
                                    <th>Parrain du Filleul</th>
                                    <th>Inscrire le</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php $__empty_1 = true; $__currentLoopData = $filleuls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filleul): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($filleul->nom); ?> <?php echo e($filleul->prenom); ?></td>
                                    <td><?php echo e($filleul->codeunique); ?></td>
                                    <td><?php echo e($filleul->codeperso); ?></td>
                                    <td>
                                      <?php if($filleul->compteactive == "oui"): ?>
                                          <i style="color: white; background-color: green; padding: 10px">actif</i>
                                      <?php else: ?>
                                          <i style="color: white; background-color: red; padding: 10px">inactif</i> 
                                      <?php endif; ?>
                                    </td>
                                    <td><?php echo e($filleul->parrain); ?></td>
                                    <td><?php echo e($filleul->created_at); ?></td>
                                </tr>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                  <td>Pas de Filleul disponible!!!</td>
                                </tr>
                              <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- #END# Hover Rows -->

    </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.template_admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>