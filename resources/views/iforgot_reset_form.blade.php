@extends('layouts.no_navbar')
@section('title', 'ลืมรหัสผ่าน')

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
<form method="POST" action="/api/v1/iforgot/request">
<input type="hidden" name="token" value="{{ $token }}" />
<div class="row" style="margin-top:30px;">
    <div class="col-md-8 col-md-offset-2">
        <h3>ลืมรหัสผ่าน</h3>
        <br />
        @if(Session::has('message'))
            <div class="alert {{ Session::get('alert-class', 'alert-info') }}"><b><i class="fa fa-exclamation-circle"></i> {{ Session::get('message') }}</b></div>
        @endif
        <div class="flat-well">
            <div class="row">
                <div class="row">
                    <div class="col-md-12" id="passwordGroup">
                        <span class="help-block">รหัสผ่าน</span>
                        <input id="password" name="password" type="password" placeholder="กำหนดรหัสผ่าน" class="form-control" />
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-12" id="password_confirmGroup">
                        <span class="help-block">ยืนยันรหัสผ่าน</span>
                        <input id="password_confirm" name="password_confirm" type="password" placeholder="กำหนดรหัสผ่านอีกครั้ง" class="form-control" />
                    </div>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-md-12" id="captchaGroup">
                    <span class="help-block">ทำเครื่องหมายถูกในช่องด้านล่าง</span>
                    {!! app('captcha')->display(); !!}
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-md-12" id="submitGroup">
                    <button type="submit" id="btnSubmit" class="btn btn-primary btn-block disabled">ขอเปลี่ยนรหัสผ่านใหม่</button>
                </div>
            </div>
        </div>
    </div>
</div>
{{ csrf_field() }}
</form>
@endsection

@section('additional_scripts')
<script>
$("#password").keyup(function(){
    checkPasswordFields();
});
$("#password_confirm").keyup(function(){
    checkPasswordFields();
});

function checkPasswordFields(){
    var pswdInput = $("#password").val();
    var pswdConfirmInput = $("#password_confirm").val();
    if(pswdInput == pswdConfirmInput){
        $("#passwordGroup").removeClass("has-warning");
        $("#password_confirmGroup").removeClass("has-warning");
        $("#passwordGroup > .help-block > .fa").remove();
        $("#password_confirmGroup > .help-block > .fa").remove();
        $("#btnSubmit").removeClass("disabled");
    }else{
        $("#passwordGroup").addClass("has-warning");
        $("#password_confirmGroup").addClass("has-warning");
        $("#passwordGroup > .help-block > .fa").remove();
        $("#password_confirmGroup > .help-block > .fa").remove();
        $("#passwordGroup > .help-block").prepend("<i class=\"fa fa-exclamation-circle\"></i> ");
        $("#password_confirmGroup > .help-block").prepend("<i class=\"fa fa-exclamation-circle\"></i> ");
        $("#btnSubmit").addClass("disabled");
    }
}
</script>
@endsection
