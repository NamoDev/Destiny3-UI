<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>@yield('title')</title>
        <link rel="stylesheet" href="/assets/css/destinyui3.css" />
    </head>
    <body>

        @include('components.navbar')

        <div class="container mainContainer">
            @yield('content');
        </div>

        <script src="/assets/js/jquery.js"></script>
        <script src="/assets/js/bootstrap.js"></script>
    </body>
</html>
