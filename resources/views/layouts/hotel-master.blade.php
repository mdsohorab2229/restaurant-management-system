{{--
    /**
     * Master Page Layout
     *
     * @package Restaurant and Hotel Management System
     * @author DataTrix Team
     */
--}}
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('page_title')</title>

        <!-- Bootstrap -->
        <link href="{{ URL::asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="{{ URL::asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
        <!-- Ionicons -->
        <link href="{{ URL::asset('assets/vendor/Ionicons/css/ionicons.min.css') }}" rel="stylesheet">
        <!-- Theme style -->
        <link href="{{ URL::asset('assets/css/main.min.css') }}" rel="stylesheet">
        <!-- Color Scheme -->
        <link href="{{ URL::asset('assets/css/skins/skin-red.min.css') }}" rel="stylesheet">

        <!-- select 2 css -->
        <link href="{{ URL::asset('assets/css/select2.min.css') }}" rel="stylesheet">

        <!-- Custom Style -->
        <link href="{{ URL::asset('assets/css/hotel_custom.css') }}" rel="stylesheet">
      

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]> <script
        src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script> <script
        src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script> <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

        {{-- Custom Header section like styles, meta tags etc. (optional) --}}
        @stack('header-assets')

        {{-- Header Styles (css) --}}
        @stack('header-styles')

        {{-- Header Scripts (js) --}}
        @stack('header-scripts')
    </head>

    <body class="hold-transition skin-red sidebar-mini">
        <div id="dt-App" class="wrapper">

            {{-- Include Header --}}
            @include('partials.hotel-header')

            {{-- Include Navigations --}}
            @if(Auth::user()->canDo('manage_admin'))
            @include('partials.hotel-navigation')
            
            
            @endif

            <!-- Content Wrapper. Contains page content -->
            <div id="dt-Body" class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        @yield('page_header')
                        <small>@yield('page_desc')</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ url('/') }}">
                                <i class="fa fa-dashboard"></i>
                                Home
                            </a>
                        </li>
                        <li class="active">@yield('page_header')</li>
                    </ol>
                </section>

                <section id="smartposPageNotice">@yield('page_notice')</section>

                <!-- Main content -->
                <section class="content container-fluid">

                    @yield('content')

                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            @include('hotel.payment.payment')

            {{-- Include Footer --}}
            @include('partials.footer')

        </div>
        <!-- ./wrapper -->



        <!--=========== REQUIRED JS SCRIPTS ===========-->

        <!-- jQuery 3 -->
        <script src="{{ URL::asset('assets/vendor/jquery/jquery.min.js') }}"></script>

        @if(true) {{-- Enable this where we need vue, may use some conditional variables, e.g. $use_vue --}}
        <!-- Axios 0.17.1 -->
        <script src="{{ URL::asset('assets/vendor/axios-js/axios.min.js') }}"></script>
        <!-- Vue 2.5.9 -->
        <script src="{{ URL::asset('assets/vendor/vue-js/vue.min.js') }}"></script>
        @endif
        @if(true) {{-- Enable when we need sweet alerts, we can inject in 'footer-scripts' section as well --}}
        <!-- SWEETALERT2 -->
        <script src="{{ URL::asset('bower_components/sweetalert2/sweetalert2.all.js') }}"></script>
        {{--<script src="{{ URL::asset('assets/vendor/vue-swal/vue-swal.js') }}"></script>--}}
        <!-- Vue the mask -->
        <script src="{{ URL::asset('assets/vendor/vue-the-mask/vue-the-mask.js') }}"></script>
        @endif

        
        {{-- laravel datatable --}}
        <script src="{{ URL::asset('assets/datatable/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ URL::asset('assets/datatable/js/dataTables.bootstrap.min.js') }}"></script>
        <link href="{{ URL::asset('assets/datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
        <script src="{{ URL::asset('assets/datatable/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ URL::asset('assets/datatable/js/buttons.flash.min.js') }}"></script>
        <script src="{{ URL::asset('assets/datatable/js/jszip.min.js') }}"></script>
        <script src="{{ URL::asset('assets/datatable/js/pdfmake.min.js') }}"></script>
        <script src="{{ URL::asset('assets/datatable/js/vfs_fonts.js') }}"></script>
        <script src="{{ URL::asset('assets/datatable/js/buttons.html5.min.js') }}"></script>
        <script src="{{ URL::asset('assets/datatable/js/buttons.print.min.js') }}"></script>
        <link href="{{ URL::asset('assets/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('assets/datatable/css/buttons.dataTables.min.css') }}" rel="stylesheet">

        <!-- Functions and Classes by MMK -->
        <script src="{{ URL::asset('assets/js/func.mmk.js') }}"></script>

        <!-- Bootstrap 3.3.7 -->
        <script src="{{ URL::asset('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
        
        <!-- AdminLTE App -->
        <script src="{{ URL::asset('assets/js/main.min.js') }}"></script>

        {{-- Custom Footer Assets (additional script tags) --}}
        @stack('footer-assets')

        <!-- Submitter Scripts -->
        <script src="{{ URL::asset('js/submitter.js') }}"></script>
        
        <!-- select2 js -->
        <script src="{{ URL::asset('assets/js/select2.full.min.js') }}"></script>

        <!-- Custom Scripts -->
        <script src="{{ URL::asset('assets/js/custom.js') }}"></script>

        <script>

            // Enable vue devtools (for development mode)
            Vue.config.devtools = true;
            // default csrf token for axios
            axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


            // Live DateTime
            var _dtDateTime = new Vue({
                el : '#dt-DateTime',
                data : {
                    time : '',
                    date : '',
                    day : '',
                    now : ''
                },
                methods : {
                    updateTime : function(){
                        var self = this;

                        var weekDays = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'];
                        var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                        var now = new Date();
                        var hours = now.getHours();
                        var ampm = (hours >= 12) ? 'PM' : 'AM';
                        if(hours > 12) { hours -= 12; }

                        this.time = zeroPadding(hours, 2) + ':' + zeroPadding(now.getMinutes(), 2) + ':' + zeroPadding(now.getSeconds(), 2) + ' ' + ampm;
                        this.date = zeroPadding(now.getDate(), 2) +' '+ months[now.getMonth()] +', '+ zeroPadding(now.getFullYear(), 4);
                        this.day = weekDays[now.getDay()];

                        setTimeout(self.updateTime, 1000);
                    }
                },
                created: function(){
                    this.updateTime();
                }
            });

            var _dtFooter = new Vue({
                el : '#dt-Footer',
                data : {
                    datatrixURL: 'http://datatrixsoft.com/request-quote',
                    datatrixMoto : 'We code to develop your idea!'
                }
            });

            $('.select2').select2();
        </script>

        {{-- Custom Footer Scripts (mostly for vue) --}}
        @stack('footer-scripts')
    </body>
</html>