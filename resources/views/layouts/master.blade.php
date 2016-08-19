<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>@yield('title') | ระบบรับสมัครนักเรียน โรงเรียนเตรียมอุดมศึกษา</title>
        <link rel="stylesheet" href="/assets/css/destinyui3.css" />
        @yield('additional_styles')
    </head>
    <body>

        @include('components.navbar')

        <div class="container mainContainer">
            <div class="row">
                <div class="col-md-3">

                  <a class="btn btn-primary btn-block" href="/application/info"><span class="fa fa-check-circle"></span> ข้อมูลพื้นฐาน</a>
                  <div class="text-center" style="margin-top:5px;margin-bottom:5px;font-size:.7em;"><i class="fa fa-arrow-down"></i></div>
                  <a class="btn btn-primary btn-block" href="/application/parent"><span class="fa fa-check-circle"></span> ข้อมูลผู้ปกครอง</a>
                  <div class="text-center" style="margin-top:5px;margin-bottom:5px;font-size:.7em;"><i class="fa fa-arrow-down"></i></div>
                  <a class="btn btn-primary btn-block" href="/application/address"><span class="fa fa-check-circle"></span> ที่อยู่ / ภูมิลำเนา</a>
                  <div class="text-center" style="margin-top:5px;margin-bottom:5px;font-size:.7em;"><i class="fa fa-arrow-down"></i></div>
                  <a class="btn btn-primary btn-block" href="/application/education"><span class="fa fa-check-circle"></span> ประวัติการศึกษา</a>
                  <div class="text-center" style="margin-top:5px;margin-bottom:5px;font-size:.7em;"><i class="fa fa-arrow-down"></i></div>
                  <a class="btn btn-primary btn-block" href="/application/plan"><span class="fa fa-check-circle"></span> เลือกแผนการเรียน</a>
                  <div class="text-center" style="margin-top:5px;margin-bottom:5px;font-size:.7em;"><i class="fa fa-arrow-down"></i></div>
                  <a class="btn btn-primary btn-block" href="/application/day"><span class="fa fa-check-circle"></span> เลือกวันสมัครที่โรงเรียน</a>
                  <br />

                  <!-- TODO: Add the real thing. -->
                  <div class="panel panel-default">
                      <div class="panel-body">
                         <small><i class="fa fa-exclamation-triangle"></i> นักเรียนยังไม่ได้พิมพ์ใบสมัคร</small>
                         <a class="btn btn-success btn-block btn-lg">พิมพ์ใบสมัคร</a>
                      </div>
                  </div>

                </div>
                <div class="col-md-9">
                  <div class="flat-well">
                    @yield('content')
                  </div>
                </div>
            </div>

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
        <script>
          var csrfToken = "<?php echo csrf_token(); ?>";
        </script>
        @yield('additional_scripts')
    </body>
</html>
