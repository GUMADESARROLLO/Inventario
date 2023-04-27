<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>INVENTARIO | INNOVA INDUSTRIA </title>
    <link rel="shortcut icon" href="{{ url('images/ic-inn.png') }}" />


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    
    <script src="{{ asset('js/theme_gumadesk/config.js') }}"></script>
    <script src="{{ asset('js/theme_gumadesk/vendors/overlayscrollbars/OverlayScrollbars.min.js') }}"></script>
    <link href="{{ asset('js/theme_gumadesk/vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" >
    <link href="{{ asset('js/theme_gumadesk/vendors/glightbox/glightbox.min.css') }}" rel="stylesheet" >
    <link href="{{ asset('js/theme_gumadesk/vendors/plyr/plyr.css') }}" rel="stylesheet" >
    <link href="{{ asset('js/theme_gumadesk/vendors/dropzone/dropzone.min.css') }}" rel="stylesheet" >
    <link href="{{ asset('js/theme_gumadesk/vendors/leaflet/leaflet.css') }}" rel="stylesheet" >
    <link href="{{ asset('js/theme_gumadesk/vendors/leaflet.markercluster/MarkerCluster.css') }}" rel="stylesheet" >
    <link href="{{ asset('js/theme_gumadesk/vendors/leaflet.markercluster/MarkerCluster.Default.css') }}" rel="stylesheet" >
    <link href="{{ asset('js/theme_gumadesk/vendors/fullcalendar/main.min.css') }}" rel="stylesheet" >
    <link href="{{ asset('js/theme_gumadesk/vendors/swiper/swiper-bundle.min.css') }}" rel="stylesheet" >
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">
    <link href="{{ asset('js/theme_gumadesk/vendors/overlayscrollbars/OverlayScrollbars.min.css') }}" rel="stylesheet" >
    
    <link href="{{ asset('css/theme_gumadesk/css/theme.min.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('css/theme_gumadesk/css/theme-rtl.css') }}" rel="stylesheet" id="style-rtl">
    <link href="{{ asset('css/theme_gumadesk/css/user.min.css') }}" rel="stylesheet" id="user-style-default">
    <link href="{{ asset('js/theme_gumadesk/vendors/choices/choices.min.css') }}" rel="stylesheet" >
    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <script>
        var linkRTL = document.getElementById('style-rtl');
        linkRTL.setAttribute('disabled', true);
    </script>
    <style>
        .bg-shape-inn {
            position: relative;
            overflow: hidden;
            background-color: #831F82;
        }
        .btn-bg-inn{
            background-color: #831F82 !important;
            border-color: #831F82 !important;
        }
        .text-primary-inn {
            --falcon-text-opacity: 1;
            color: #831F82 !important;
        }
        .text-info-inn {
            --falcon-text-opacity: 1;
            color: #F39200 !important;
        }
        .border-table{
            border: 1px solid var(--falcon-border-color);
            box-shadow: var(--falcon-box-shadow-sm);
            border-radius: .375rem;
            color: var(--falcon-1000);
            text-decoration: none;
            background-color: var(--falcon-notification-bg);
     
            font-size: .8333333333rem;
      
            transition: all .2s ease-in-out;

        }
    </style>
</head>
<body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <div id="app">
        @yield('content')
    </div>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->




    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->

    <script src="{{ asset('js/theme_gumadesk/vendors/popper/popper.min.js') }}"></script>
    <script src="{{ asset('js/theme_gumadesk/vendors/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/theme_gumadesk/vendors/anchorjs/anchor.min.js') }}"></script>
    <script src="{{ asset('js/theme_gumadesk/vendors/is/is.min.js') }}"></script>
    <script src="{{ asset('js/theme_gumadesk/vendors/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('js/theme_gumadesk/vendors/glightbox/glightbox.min.js') }}"></script>    
    <script src="{{ asset('js/theme_gumadesk/flatpickr.js') }}"></script>
    <script src="{{ asset('js/theme_gumadesk/vendors/echarts/echarts.min.js') }}"></script>    
    <script src="{{ asset('js/theme_gumadesk/world.js') }}"></script>
    <script src="{{ asset('js/theme_gumadesk/vendors/plyr/plyr.polyfilled.min.js') }}"></script>    
    <script src="{{ asset('js/theme_gumadesk/vendors/countup/countUp.umd.js') }}"></script>    
    <script src="{{ asset('js/theme_gumadesk/vendors/chart/chart.min.js') }}"></script>
    <script src="{{ asset('js/theme_gumadesk/vendors/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('js/theme_gumadesk/vendors/leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('js/theme_gumadesk/vendors/leaflet.markercluster/leaflet.markercluster.js') }}"></script>
    <script src="{{ asset('js/theme_gumadesk/vendors/leaflet.tilelayer.colorfilter/leaflet-tilelayer-colorfilter.min.js') }}"></script>
    <script src="{{ asset('js/theme_gumadesk/vendors/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('js/theme_gumadesk/vendors/dayjs/dayjs.min.js') }}"></script>
    <script src="{{ asset('js/theme_gumadesk/vendors/fullcalendar/main.min.js') }}" ></script>
    <script src="{{ asset('js/theme_gumadesk/vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('js/theme_gumadesk/vendors/lodash/lodash.min.js') }}"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="{{ asset('js/theme_gumadesk/vendors/list.js/list.min.js') }}"></script>
    <script src="{{ asset('js/theme_gumadesk/theme.js') }}"></script>
    <script src="{{ asset('js/theme_gumadesk/vendors/choices/choices.min.js') }}"></script>
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/es.min.js"></script>
    <script src="{{ asset('js/Numeral.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery-3.5.1.js') }}"></script>
    
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>    
    <script src="{{ asset('js/jszip.js') }}"></script>
    <script src="{{ asset('js/xlsx.js') }}"></script>
    <script src="https://cdn.datatables.net/select/1.4.0/js/dataTables.select.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    @yield('metodosjs')
    <script type="text/javascript">

        function isNumberKey(evt){
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
                return false;

            return true;
        }

        
    </script>

    
</body>

</html>