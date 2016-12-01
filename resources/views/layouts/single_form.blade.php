<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <title>@yield('title') | ระบบรับสมัครนักเรียน โรงเรียนเตรียมอุดมศึกษา</title>
        <link rel="stylesheet" href="/assets/css/destinyui3.css" />
        @yield('additional_styles')
    </head>
    <body>

        @include('components.navbar')

        <div class="container mainContainer">
            <div class="row">
                <div class="col-md-12">
                  <div class="well">
                    @yield('content')
                  </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 text-right">
                    <br />
                    <h6 class="footer_line">v3.0.1 <span class="text-muted">|</span> สงวนลิขสิทธิ์ &copy; โรงเรียนเตรียมอุดมศึกษา</h6>
                    <br />
                </div>
            </div>

        </div>

        <script src="/assets/js/jquery.js"></script>
        <script src="/assets/js/bootstrap.js"></script>
        <script src="/assets/js/pace.min.js"></script>
        <script>
          var csrfToken = "<?php echo csrf_token(); ?>";
        </script>
        <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-75488426-2', 'auto');
  ga('send', 'pageview');

</script>
        @yield('additional_scripts')
    </body>
</html>
