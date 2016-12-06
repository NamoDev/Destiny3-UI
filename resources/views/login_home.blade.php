@extends('layouts.no_navbar')
@section('title', 'หน้าหลัก')

@section('content')
<!--
  ________  ______  ______
 /_  __/ / / / __ \/_  __/
  / / / / / / / / / / /
 / / / /_/ / /_/ / / /
/_/  \____/_____/ /_/

TUEnt "Destiny", (C) {{ date("Y") }} TUDT.

The world could always use more developers. Are you with us?
https://tucc.triamudom.ac.th

-->
<div class="row" style="margin-top:80px;">
    <div class="col-md-12">
        <h1>ระบบรับสมัครนักเรียน@if(Config::get('uiconfig.mode') == 'province_quota')โควตาจังหวัด @endif<br />โรงเรียนเตรียมอุดมศึกษา</h1>
        <h4>
            @if(Config::get('uiconfig.isPTR') === true)
                <span class="label label-info" style="font-size:.65em;font-weight:normal;letter-spacing:.05em;text-align:center;">
                    PTR
                </span>
            @elseif(Config::get('app.debug') === true)
                <span class="label label-info" style="font-size:.65em;font-weight:normal;letter-spacing:.05em;text-align:center;">
                    Beta Build
                </span>
            @endif
        </h4>
    </div>
</div>

<div class="row" style="margin-top:15px;">
    <div class="col-md-6">
        <form class="login-form" method="POST" action="/login">
            <legend>
                เข้าสู่ระบบ
                @if(Session::has('message'))
                    @if(Session::get('message') == 'INVALID_USERNAME_OR_PASSWORD')
                        <span class="pull-right"><i data-toggle="tooltip" data-placement="top" title="รหัสประจำตัวประชาชน หรือรหัสผ่านไม่ถูกต้อง" class="fa fa-exclamation-triangle text-warning login_alert_icon"></i></span>
                    @elseif(Session::get('message') == 'NOT_LOGGED_IN')
                        <span class="pull-right"><i data-toggle="tooltip" data-placement="top" title="คุณยังไม่ได้เข้าสู่ระบบ หรือการเข้าสู่ระบบหมดอายุ" class="fa fa-exclamation-triangle text-warning login_alert_icon"></i></span>
                    @else
                        <span class="pull-right"><i data-toggle="tooltip" data-placement="top" title="เกิดข้อผิดพลาดในการเข้าสู่ระบบ กรุณาลองใหม่อีกครั้งภายหลัง" class="fa fa-exclamation-triangle text-warning login_alert_icon"></i></span>
                    @endif
                @endif
            </legend>

            @if(Session::has('message'))
                @if(Session::get('message') != 'INVALID_USERNAME_OR_PASSWORD' and Session::get('message') != 'NOT_LOGGED_IN')
                    @if(Session::get('message') != 'LOGIN_EXCEPTION_THROWN')
                        <div class="alert {{ Session::get('alert-class', 'alert-info') }}"><b>{{ Session::get('message') }}</b></div>
                    @endif
                @endif
            @endif

            <div class="form-group {{ session('message') == 'INVALID_USERNAME_OR_PASSWORD' ? ' has-warning' : '' }}">
                <input type="text" class="form-control login-field" value="" placeholder="รหัสประจำตัวประชาชน" id="login_id" name="login_name" />
                <label class="login-field-icon fui-user" for="login_name"></label>
            </div>

            <div class="form-group {{ session('message') == 'INVALID_USERNAME_OR_PASSWORD' ? ' has-warning' : '' }}">
                <input type="password" class="form-control login-field" value="" placeholder="รหัสผ่าน" id="login_password" name="login_password" />
                <label class="login-field-icon fui-lock" for="login_pass"></label>
            </div>

            {{ csrf_field() }}

            <button class="btn btn-primary btn-lg btn-block" type="submit">เข้าสู่ระบบ</button>
            <a class="login-link" href="/iforgot">ลืมรหัสผ่าน?</a>
        </form>
    </div>
    <div class="col-md-6">
        <div class="flat-well">
            <legend>ยังไม่เคยลงทะเบียนใช่หรือไม่?</legend>
            <a class="btn btn-primary btn-lg btn-block" href="/application/tos">สมัครใหม่</a>
        </div>
        <div class="flat-well" style="margin-top:10px;">
            <legend>เกิดปัญหาในการสมัคร?</legend>
            <div class="row">
                <div class="col-xs-6">
                    <a class="btn btn-primary btn-lg btn-block" href="/faq">คำถามที่พบบ่อย</a>
                </div>
                <div class="col-xs-6">
                    <a class="btn btn-primary btn-lg btn-block" href="/support" target="_blank">ขอความช่วยเหลือ</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" style="margin-top:30px;">
    <div class="col-md-12">

    </div>
</div>

@endsection

@section('additional_scripts')
<script>
    if (!(typeof Promise !== "undefined" && Promise.toString().indexOf("[native code]") !== -1)) {
        // Check for old browser by checking Promises support, which is not present in old browsers.
        // Visit http://caniuse.com/#feat=promises for more information
        window.location.href = "/bad_browser";
    }
    // Separate script tag, minimizing errors in case of script mulfunction
</script>
<script>
$(function () {
    $('[data-toggle="tooltip"]').tooltip();
})
</script>
@endsection
