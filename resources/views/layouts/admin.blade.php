<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ config('app.name', 'Laravel') }} | AdminDashboard</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="all,follow">
  <!-- Bootstrap CSS-->
  <link rel="stylesheet" href="{{ url('vendor/bootstrap/css/bootstrap.min.css')}}">
  <!-- Font Awesome CSS-->

  <link rel="stylesheet" href="{{ url('vendor/font-awesome/css/font-awesome.min.css')}}"> {{--
  <link rel="stylesheet" href="{{ url('css/fontawesome.min.css') }}"> --}}

  <!-- Fontastic Custom icon font-->
  <link rel="stylesheet" href="{{ url('css/fontastic.css')}}">
  <!-- Google fonts - Roboto -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
  <!-- jQuery Circle-->
  <link rel="stylesheet" href="{{ url('css/grasp_mobile_progress_circle-1.0.0.min.css')}}">
  <!-- Custom Scrollbar-->
  <link rel="stylesheet" href="{{ url('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css')}}">
  <!-- theme stylesheet-->
  <link rel="stylesheet" href="{{ url('css/style.default.css')}}" id="theme-stylesheet">
  <!-- Custom stylesheet - for your changes-->
  <link rel="stylesheet" href="{{ url('css/custom.css')}}">
  <!-- Favicon-->
  <link rel="shortcut icon" href="{{ url('img/favicon.ico')}}">
  <script src="{{ url('vendor/jquery/jquery.min.js')}}"></script>


</head>

<body>
  @include('inc.sidenavbar')
  <div class="page">
  @include('inc.header'){{--
  @include('inc.msg')
  @include('inc.counts')
  @include('inc.headsections')
  @include('inc.statistics')
  @include('inc.updates') --}} @yield('content')
  @include('inc.footer')
  </div>
  <!-- JavaScript files-->
  <script src="{{ url('vendor/popper.js/umd/popper.min.js')}}"></script>
  <script src="{{ url('vendor/bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{ url('vendor/chart.js/Chart.min.js')}}"></script>
  <script src="{{ url('vendor/jquery.cookie/jquery.cookie.js')}}"></script>
  <script src="{{ url('vendor/jquery-validation/jquery.validate.min.js')}}"></script>
  <script src="{{ url('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')}}"></script>

  <script src="{{ url('js/fa.js')}}"></script>
  <script src="{{ url('js/grasp_mobile_progress_circle-1.0.0.min.js')}}"></script>
  <script src="{{ url('js/charts-home.js')}}"></script>
  <!-- Main File-->
  <script src="{{ url('js/front.js')}}"></script>
</body>

</html>