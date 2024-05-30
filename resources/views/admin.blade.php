<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name') ?? '' }}</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('dashboard_assets') }}/plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet"
        href="{{ asset('dashboard_assets') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ asset('dashboard_assets') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ asset('dashboard_assets') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dashboard_assets') }}/dist/css/adminlte.min.css">

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body class="font-sans antialiased">
    @inertia
    <!-- jQuery -->
    <script src="{{ asset('dashboard_assets') }}/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('dashboard_assets') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('dashboard_assets') }}/plugins/datatables/jquery.dataTables.min.js"></script>

    <script src="{{ asset('dashboard_assets') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('dashboard_assets') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>

    {{-- <script src="{{ asset('dashboard_assets') }}/custom/datatable.js"></script> --}}

    <!-- AdminLTE App -->
    <script src="{{ asset('dashboard_assets') }}/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    {{-- <script src="{{ asset('dashboard_assets') }}/dist/js/demo.js"></script> --}}
</body>


</html>
