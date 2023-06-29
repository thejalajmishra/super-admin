<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <link rel="stylesheet" href="/dist/css/adminlte.min.css">
        @yield('page-style')
        @include('sweetalert::alert')
    </head>
    <body class="hold-transition dark-mode login-page">
        <div class="login-box">
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="/" class="h1">{{ config('app.name', 'Laravel') }}</a>
                </div>
                <div class="card-body">
                    @yield('contents')
                </div>
            </div>
        </div>
        <script src="/plugins/jquery/jquery.min.js"></script>
        <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/dist/js/adminlte.min.js"></script>
        @yield('page-script')
    </body>
</html>
