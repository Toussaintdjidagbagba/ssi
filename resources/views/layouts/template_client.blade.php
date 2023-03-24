<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="La plateforme qui vous conduit au sommet.">
  <meta name="author" content="SSI">
  
  <link rel="shortcut icon" href="{{ asset('img/logo.jpeg') }}">

  <title>Mon Compte SSI</title>

  <!-- Bootstrap CSS -->
  <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
  <!-- bootstrap theme -->
  <link href="{{ asset('assets/css/bootstrap-theme.css') }}" rel="stylesheet">
  <!--external css-->
  <!-- font icon -->
  <link href="{{ asset('assets/css/elegant-icons-style.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet" />
  <!-- full calendar css-->
  <link href="{{ asset('assets/assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/assets/fullcalendar/fullcalendar/fullcalendar.css') }}" rel="stylesheet" />
  <!-- easy pie chart-->
  <link href="{{ asset('assets/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css') }}" rel="stylesheet" type="text/css" media="screen" />
  <!-- owl carousel -->
  <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.css') }}" type="text/css">
  <link href="{{ asset('assets/css/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet">
  <!-- Custom styles -->
  <link rel="stylesheet" href="{{ asset('assets/css/fullcalendar.css') }}">
  <link href="{{ asset('assets/css/widgets.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/style-responsive.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/xcharts.min.css') }}" rel=" stylesheet">
  <link href="{{ asset('assets/css/jquery-ui-1.10.4.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>

  @yield('css')

  <style type="text/css">
    .alert-success {
      background-color: #dff8e3;
      border-color: #4CAF50;
      color: #4CAF50;
      border-radius: 50px;
    }
  </style>


</head>

<body>
  <!-- container section start -->
  <section id="container" class="">


    @include('client.header')

    @include('client.menu')

    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        @include('flash::message')

        @yield('content')

    </section>
    </section>

    <!--main content end-->

    <!-- Footer -->
          <footer class="sticky-footer bg-white">
            <div class="container">
              <div class="copyright text-center ">
                <span>Copyright &copy; Source du Succès International <?php echo date('Y')?> </span>
              </div>
            </div>
          </footer>
          <!-- End of Footer -->

  </section>
  <!-- container section start -->

  <!-- javascripts -->
  <script src="{{ asset('assets/js/jquery.js') }}"></script>
  <script src="{{ asset('assets/js/jquery-ui-1.10.4.min.js') }}"></script>
  <script src="{{ asset('assets/js/jquery-1.8.3.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/jquery-ui-1.9.2.custom.min.js') }}"></script>
  <!-- bootstrap -->
  <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
  <!-- nice scroll -->
  <script src="{{ asset('assets/js/jquery.scrollTo.min.js') }}"></script>
  <script src="{{ asset('assets/js/jquery.nicescroll.js') }}" type="text/javascript"></script>
  <!-- charts scripts -->
  <script src="{{ asset('assets/assets/jquery-knob/js/jquery.knob.js') }}"></script>
  <script src="{{ asset('assets/js/jquery.sparkline.js') }}" type="text/javascript"></script>
  <script src="{{ asset('assets/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js') }}"></script>
  <script src="{{ asset('assets/js/owl.carousel.js') }}"></script>
  <!-- jQuery full calendar -->
  <<script src="{{ asset('assets/js/fullcalendar.min.js') }}"></script>
    <!-- Full Google Calendar - Calendar -->
    <script src="{{ asset('assets/assets/fullcalendar/fullcalendar/fullcalendar.js') }}"></script>
    <!--script for this page only-->
    <script src="{{ asset('assets/js/calendar-custom.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.rateit.min.js') }}"></script>
    <!-- custom select -->
    <script src="{{ asset('assets/js/jquery.customSelect.min.js') }}"></script>
    <script src="{{ asset('assets/assets/chart-master/Chart.js') }}"></script>

    <!--custome script for all page-->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <!-- custom script for this page-->
    <script src="{{ asset('assets/js/sparkline-chart.js') }}"></script>
    <script src="{{ asset('assets/js/easy-pie-chart.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('assets/js/xcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.autosize.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.placeholder.min.js') }}"></script>
    <script src="{{ asset('assets/js/gdp-data.js') }}"></script>
    <script src="{{ asset('assets/js/morris.min.js') }}"></script>
    <script src="{{ asset('assets/js/sparklines.js') }}"></script>
    <script src="{{ asset('assets/js/charts.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>

     @yield('javascripts')

    <script>
      //knob
      $(function() {
        $(".knob").knob({
          'draw': function() {
            $(this.i).val(this.cv + '%')
          }
        })
      });

      //carousel
      $(document).ready(function() {
        $("#owl-slider").owlCarousel({
          navigation: true,
          slideSpeed: 300,
          paginationSpeed: 400,
          singleItem: true

        });
      });

      //custom select box

      $(function() {
        $('select.styled').customSelect();
      });

      /* ---------- Map ---------- */
      $(function() {
        $('#map').vectorMap({
          map: 'world_mill_en',
          series: {
            regions: [{
              values: gdpData,
              scale: ['#000', '#000'],
              normalizeFunction: 'polynomial'
            }]
          },
          backgroundColor: '#eef3f7',
          onLabelShow: function(e, el, code) {
            el.html(el.html() + ' (GDP - ' + gdpData[code] + ')');
          }
        });
      });
    </script>

</body>

</html>