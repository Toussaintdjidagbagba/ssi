<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="La plateforme qui vous conduit au sommet.">
  <meta name="author" content="SSI">
  <?php echo $__env->yieldContent('meta'); ?>
  
  <link rel="shortcut icon" href="<?php echo e(asset('img/logo.jpeg')); ?>">

  <title>Mon compte SSI (REFONTE) </title>

  <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?php echo e(asset('newcssadmin/plugins/bootstrap/css/bootstrap.css')); ?>" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?php echo e(asset('newcssadmin/plugins/node-waves/waves.css')); ?>" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?php echo e(asset('newcssadmin/plugins/animate-css/animate.css')); ?>" rel="stylesheet" />

    <!-- Morris Chart Css-->
    <link href="<?php echo e(asset('newcssadmin/plugins/morrisjs/morris.css')); ?>" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?php echo e(asset('newcssadmin/css/style.css')); ?>" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?php echo e(asset('newcssadmin/css/themes/all-themes.css')); ?>" rel="stylesheet" />

  <?php echo $__env->yieldContent('css'); ?>

  <style type="text/css">
    .alert-success {
      background-color: #dff8e3;
      border-color: #4CAF50;
      color: #4CAF50;
      border-radius: 50px;
    }
  </style>

</head>

<body class="theme-red">
  <!-- container section start -->
  <section id="container" class="">


    <?php echo $__env->make('admin.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo $__env->make('admin.menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <?php echo $__env->make('flash::message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <?php echo $__env->yieldContent('content'); ?>

    </section>
    </section>

    <!--main content end-->

    <!-- Footer -->
          <!-- <footer class="sticky-footer bg-white">
            <div class="container">
              <div class="copyright text-center ">
                <span>Copyright &copy; Source du Succès International <?php echo date('Y')?> </span>
              </div>
            </div>
          </footer> -->
          <!-- End of Footer -->

  </section>
  <!-- container section start -->

  <!-- javascripts -->

    <!-- Jquery Core Js -->
    <script src="<?php echo e(asset('newcssadmin/plugins/jquery/jquery.min.js')); ?>"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?php echo e(asset('newcssadmin/plugins/bootstrap/js/bootstrap.js')); ?>"></script>

    <!-- Select Plugin Js -->
    <script src="<?php echo e(asset('newcssadmin/plugins/bootstrap-select/js/bootstrap-select.js')); ?>"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="<?php echo e(asset('newcssadmin/plugins/jquery-slimscroll/jquery.slimscroll.js')); ?>"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo e(asset('newcssadmin/plugins/node-waves/waves.js')); ?>"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="<?php echo e(asset('newcssadmin/plugins/jquery-countto/jquery.countTo.js')); ?>"></script>

    <!-- Morris Plugin Js -->
    <script src="<?php echo e(asset('newcssadmin/plugins/raphael/raphael.min.js')); ?>"></script>
    <script src="<?php echo e(asset('newcssadmin/plugins/morrisjs/morris.js')); ?>"></script>

    <!-- ChartJs -->
    <script src="<?php echo e(asset('newcssadmin/plugins/chartjs/Chart.bundle.js')); ?>"></script>

    <!-- Flot Charts Plugin Js -->
    <script src="<?php echo e(asset('newcssadmin/plugins/flot-charts/jquery.flot.js')); ?>"></script>
    <script src="<?php echo e(asset('newcssadmin/plugins/flot-charts/jquery.flot.resize.js')); ?>"></script>
    <script src="<?php echo e(asset('newcssadmin/plugins/flot-charts/jquery.flot.pie.js')); ?>"></script>
    <script src="<?php echo e(asset('newcssadmin/plugins/flot-charts/jquery.flot.categories.js')); ?>"></script>
    <script src="<?php echo e(asset('newcssadmin/plugins/flot-charts/jquery.flot.time.js')); ?>"></script>

    <!-- Sparkline Chart Plugin Js -->
    <script src="<?php echo e(asset('newcssadmin/plugins/jquery-sparkline/jquery.sparkline.js')); ?>"></script>

    <!-- Custom Js -->
    <script src="<?php echo e(asset('newcssadmin/js/admin.js')); ?>"></script>
    <script src="<?php echo e(asset('newcssadmin/js/pages/index.js')); ?>"></script>

    <!-- Demo Js -->
    <script src="<?php echo e(asset('newcssadmin/js/demo.js')); ?>"></script>

</body>

</html>