<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap 3 Core Css -->
    <link href="{{ asset('plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <!-- Waves Effect Css -->
    <link href="{{ asset('plugins/node-waves/waves.css') }}" rel="stylesheet" />
    <!-- Animation Css -->
    <link href="{{ asset('plugins/animate-css/animate.css') }}" rel="stylesheet" />
    <!-- JQuery DataTable Css -->
    <link href="{{ asset('plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
    <!-- Custom Css -->

    <!-- Bootstrap Select Css -->
    <link href="{{ asset('plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />

    <!-- Sweetalert Css -->
    <link href="{{ asset('plugins/sweetalert/sweetalert.css') }}" rel="stylesheet" />

    @yield('styles')

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{ asset('css/themes/all-themes.css') }}" rel="stylesheet" />


</head>
<body class="theme-blue">
    <div id="app">
        @include('included.header')
        @include('included.sidebar')

        <main class="py-4">
            <section class="content">
                @if (session('status'))
                    <div class="container-fluid">
                        <div class="system-alerts-messages alert alert-{{ session('status') }}">
                            <strong>{{ session('status') != 'success' ? 'Failed' : 'Success' }}!</strong> {{ session('message') }}
                        </div>
                    </div>
                @endif
                @yield('content')
                <!-- Footer -->
                <div class="legal">
                    <div class="copyright text-right m-r-15 m-l-15 p-b-15">
                        &copy; 2021 - {{ date('Y') }} <a href="https://fixitsol.com/">fixitsol</a>
                    </div>
                </div>
                <!-- #Footer -->
            </section>
            <!-- Page Loader -->
            <div class="page-loader-wrapper">
                <div class="loader">
                    <div class="preloader">
                        <div class="spinner-layer pl-red">
                            <div class="circle-clipper left">
                                <div class="circle"></div>
                            </div>
                            <div class="circle-clipper right">
                                <div class="circle"></div>
                            </div>
                        </div>
                    </div>
                    <p>Please wait...</p>
                </div>
            </div>
            <!-- #END# Page Loader -->
            @include('included.footer')
        </main>
        @yield('scripts')
        @yield('auth-scripts')

        <script>
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                setTimeout(() => {
                    $('.system-alerts-messages').fadeOut(100);
                }, 5 * 1000);
            });

            $(document).on('click', '[data-type="form-confirm"]', function(e) {
                e.preventDefault();
                let $this = $(this);
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this back!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false
                }, function (isConfirm) {
                    if(isConfirm){
                        $this.closest('form').submit();
                        // swal("Deleted!", "Your record has been deleted.", "success");
                    }
                });
            });
        </script>

    </div>
</body>
</html>
