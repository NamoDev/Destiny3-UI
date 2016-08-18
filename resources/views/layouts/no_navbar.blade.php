<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>@yield('title')</title>
        <link rel="stylesheet" href="/assets/css/destinyui3.css" />
        @yield('additional_styles')
    </head>
    <body>

        <div class="container mainContainer">
            @yield('content')

            <div class="row">
                <div class="col-xs-12 text-right">
                    <br />
                    <h6 class="footer_line">v3.0.1 <span class="text-muted">|</span> สงวนลิขสิทธิ์ &copy; โรงเรียนเตรียมอุดมศึกษา <span class="text-muted">|</span> <a href="/about">เกี่ยวกับโปรแกรม</a></h6>
                    <br />
                </div>
            </div>

        </div>

        <script src="/assets/js/jquery.js"></script>
        <script src="/assets/js/bootstrap.js"></script>
        <script src="/assets/js/destinyui3.js"></script>
        <script>
          var csrfToken = "{{csrf_token}}";
        </script>
        @yield('additional_scripts')
    </body>
</html>
