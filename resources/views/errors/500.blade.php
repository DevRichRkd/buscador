<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Orbiter is a bootstrap minimal & clean admin template">
    <meta name="keywords" content="admin, admin panel, admin template, admin dashboard, responsive, bootstrap 4, ui kits, ecommerce, web app, crm, cms, html, sass support, scss">
    <meta name="author" content="Themesbox">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>{{env('APP_NAME')}}</title>
    <!-- Fevicon -->
    <!--link rel="shortcut icon" href="assets/images/favicon.ico"-->
    <!-- Start css -->
    <!-- Switchery css -->
    <link href="{{ asset('assets/plugins/switchery/switchery.min.css')}}" rel="stylesheet">
    <!-- Apex css -->
    <link href="{{ asset('assets/plugins/apexcharts/apexcharts.css')}}" rel="stylesheet">
    <!-- Slick css -->
    <link href="{{ asset('assets/plugins/slick/slick.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/slick/slick-theme.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/sweet-alert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/flag-icon.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.5.95/css/materialdesignicons.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('hotspot') }}/jquery.hotspot.css">
    <style>
        div.dataTables_wrapper {
        width: 80%;
        margin: 0 auto;
    }
    </style>
    <!-- End css -->
</head>
<body >
    @include("layouts.partials.navbar-website")
    
    <div class="container">
        <div class="col-lg-8 offset-2 mt-5 text-center">
            <h2>La información solicitada no se encuentra en nuestro sistema, por favor intenta con otros valores</h2>

            <a href="{{url('/')}}" class="btn btn-outline-dark"> Regresar</a>
        </div>
    </div>    

    <!-- Start js -->        
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.24.1/feather.js" integrity="sha256-FYpdV7ChCZtW4xZWtO5QNyY5ynaAm843CE8jjyJzCAw=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.24.1/dist/feather.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('assets/js/detect.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('assets/js/vertical-menu.js') }}"></script>
    <!-- Switchery js -->
    <script src="{{ asset('assets/plugins/switchery/switchery.min.js') }}"></script>
    <!-- Apex js -->
    <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/apexcharts/irregular-data-series.js') }}"></script>
    <!-- Slick js -->
    <script src="{{ asset('assets/plugins/slick/slick.min.js') }}"></script>
    <!-- Custom Dashboard js -->   
    <script src="{{ asset('assets/js/custom/custom-dashboard.js') }}"></script>
    <!-- Sweet-Alert js -->
    <script src="{{ asset('assets/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
    <script src="{{ asset('assets/js/custom/custom-sweet-alert.js')}}"></script>

    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="{{ asset('hotspot')}}/jquery.hotspot.js"></script>
</body>
</html>