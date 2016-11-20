<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>@yield('title') | ระบบรับสมัครนักเรียน โรงเรียนเตรียมอุดมศึกษา</title>
        <link rel="stylesheet" href="/assets/css/destinyui3.css" />
        <meta name="google-site-verification" content="yh4lPd8jGgkRAV5WrvHEE9dXsu17w85Ytw3-fUUv4no" />
        @yield('additional_styles')
    </head>
    <body>

        @include('components.navbar')

        <div class="container mainContainer">
            <div class="row">
                <div class="col-md-3">

                    @if(!Applicant::quotaSubmissionUnderReview())

                    <a class="btn @if(App\Http\Controllers\Helper::checkStepCompletion(1)) btn-primary @else btn-default @endif btn-block" href="/application/info">@if(App\Http\Controllers\Helper::checkStepCompletion(1)) <span class="fa fa-check-circle"></span> @endif ข้อมูลพื้นฐาน</a>
                    <div class="text-center" style="margin-top:5px;margin-bottom:5px;font-size:.7em;"><i class="fa fa-arrow-down"></i></div>

                    <a class="btn @if(App\Http\Controllers\Helper::checkStepCompletion(2)) btn-primary @else btn-default @endif btn-block" href="/application/parent">@if(App\Http\Controllers\Helper::checkStepCompletion(2)) <span class="fa fa-check-circle"></span> @endif ข้อมูลผู้ปกครอง</a>
                    <div class="text-center" style="margin-top:5px;margin-bottom:5px;font-size:.7em;"><i class="fa fa-arrow-down"></i></div>

                    <a class="btn @if(App\Http\Controllers\Helper::checkStepCompletion(3)) btn-primary @else btn-default @endif btn-block" href="/application/address">@if(App\Http\Controllers\Helper::checkStepCompletion(3)) <span class="fa fa-check-circle"></span> @endif ที่อยู่ / ภูมิลำเนา</a>
                    <div class="text-center" style="margin-top:5px;margin-bottom:5px;font-size:.7em;"><i class="fa fa-arrow-down"></i></div>

                    <a class="btn @if(App\Http\Controllers\Helper::checkStepCompletion(4)) btn-primary @else btn-default @endif btn-block" href="/application/education">@if(App\Http\Controllers\Helper::checkStepCompletion(4)) <span class="fa fa-check-circle"></span> @endif ประวัติการศึกษา</a>
                    <div class="text-center" style="margin-top:5px;margin-bottom:5px;font-size:.7em;"><i class="fa fa-arrow-down"></i></div>

                    @if(Config::get('uiconfig.mode') == 'province_quota')
                    {{-- Quota only: grade information --}}
                    <a class="btn @if(App\Http\Controllers\Helper::checkStepCompletion(8)) btn-primary @else btn-default @endif btn-block" href="/application/grade">@if(App\Http\Controllers\Helper::checkStepCompletion(8)) <span class="fa fa-check-circle"></span> @endif ประวัติผลการเรียน</a>
                    <div class="text-center" style="margin-top:5px;margin-bottom:5px;font-size:.7em;"><i class="fa fa-arrow-down"></i></div>
                    @endif

                    <a class="btn @if(App\Http\Controllers\Helper::checkStepCompletion(5)) btn-primary @else btn-default @endif btn-block" href="/application/plan">@if(App\Http\Controllers\Helper::checkStepCompletion(5)) <span class="fa fa-check-circle"></span> @endif เลือกแผนการเรียน</a>
                    <div class="text-center" style="margin-top:5px;margin-bottom:5px;font-size:.7em;"><i class="fa fa-arrow-down"></i></div>

                    @if(Config::get('uiconfig.mode') != 'province_quota')
                    {{-- Normal only: application day selection. NOTE: This may be removed in the future! --}}
                    <a class="btn @if(App\Http\Controllers\Helper::checkStepCompletion(6)) btn-primary @else btn-default @endif btn-block" href="/application/day">@if(App\Http\Controllers\Helper::checkStepCompletion(6)) <span class="fa fa-check-circle"></span> @endif เลือกวันสมัครที่โรงเรียน</a>
                    <div class="text-center" style="margin-top:5px;margin-bottom:5px;font-size:.7em;"><i class="fa fa-arrow-down"></i></div>
                    @endif

                    <a class="btn @if(App\Http\Controllers\Helper::checkStepCompletion(7)) btn-primary @else btn-default @endif btn-block" href="/application/documents">@if(App\Http\Controllers\Helper::checkStepCompletion(7)) <span class="fa fa-check-circle"></span> @endif อัพโหลดเอกสาร</a>
                    <br />

                    @endif

                  @if(Applicant::allStepComplete())
                  <div class="panel panel-default">
                      <div class="panel-body">
                        <a class="btn btn-block btn-success disabled">ส่งข้อมูล</a>
                        <small><i class="fa fa-exclamation-circle"></i> นักเรียนยังไม่ได้ส่งข้อมูล</small>
                      </div>
                  </div>
                  @else
                  <div class="panel panel-default">
                      <div class="panel-body">
                          @if(Applicant::quotaSubmissionUnderReview())
                              <small><i class="fa fa-info-circle"></i> ข้อมูลของนักเรียนอยู่ระหว่างการตรวจสอบ</small>
                          @else
                                <a class="btn btn-block btn-success" href="/application/quota_confirm">ส่งข้อมูล</a>
                                <small><i class="fa fa-exclamation-circle"></i> นักเรียนยังไม่ได้ส่งข้อมูล</small>
                          @endif
                      </div>
                  </div>
                  @endif

                </div>
                <div class="col-md-9">

                  <div class="flat-well">
                    @yield('content')
                  </div>

                  @if(Config::get('app.debug') === true)
                  {{-- Debug box (a.k.a. "Angela") that only appears if debug mode is enabled --}}
                  <br />
                  <div class="flat-well">
                      <h5><i class="fa fa-cubes"></i> Debug Mode<i class="text-muted pull-right">Applicant data dump</i></h5>
                      <div>
                          <pre>
                              <?php
                              try{
                                  print_r($applicantData);
                              }catch(\Throwable $stuff){
                                  echo("User data not loaded on this page");
                              }
                               ?>
                          </pre>
                      </div>
                  </div>
                  @endif

                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 text-right">
                    <br />
                    <h6 class="footer_line">v3.0.1 <span class="text-muted">|</span> สงวนลิขสิทธิ์ &copy; โรงเรียนเตรียมอุดมศึกษา <span class="text-muted">|</span> <a href="/about">เกี่ยวกับโปรแกรม</a></h6>
                    <br />
                </div>
            </div>

            <div id="plsWaitModal" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-body">
                    <i class="fa fa-spinner fa-spin"></i> กรุณารอสักครู่
                  </div>
                </div>
              </div>
            </div>

        </div>

        <script src="/assets/js/jquery.js"></script>
        <script src="/assets/js/destinyui3.js"></script>
        <script src="/assets/js/jsCheckers.js"></script>
        <script src="/assets/js/bootbox.min.js"></script>
        <script src="/assets/js/pace.min.js"></script>
        <script>
          var csrfToken = "<?php echo csrf_token(); ?>";
          $('#plsWaitModal').modal({
            backdrop: 'static',
            keyboard: false,
            show: false
          });

          $(function(){
              $(':checkbox').radiocheck();
              $("select").select2({dropdownCssClass: 'dropdown-inverse'});
          })

          function notify(message, severity){
              $("#formAlertMessage").html(message);
              $("#formAlertMessage").removeClass();
              $("#formAlertMessage").addClass('text-' + severity);
              $("#formAlertMessage").fadeIn(300);
          }

          function clearNotifications(){
              $("#formAlertMessage").fadeOut(300);
          }

        </script>
        @yield('additional_scripts')
    </body>
</html>
