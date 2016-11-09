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
<form method="POST" action="/api/v1/iforgot/submit">
<div class="row" style="margin-top:30px;">
    <div class="col-md-8 col-md-offset-2">
        <h3>ลืมรหัสผ่าน</h3>
        <br />
        @if(Session::has('message'))
            <div class="alert {{ Session::get('alert-class', 'alert-info') }}"><b><i class="fa fa-exclamation-circle"></i> {{ Session::get('message') }}</b></div>
        @endif
        <div class="flat-well">
            <div class="row">
                <div class="col-md-12" id="citizenidGroup">
                    <span class="help-block">รหัสประจำตัวประชาชน</span>
                    <input id="citizenid" name="citizenid" type="text" placeholder="รหัสประจำตัวประชาชน 13 หลัก ไม่ต้องใส่ขีดคั่น" class="form-control" />
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
                    <button type="submit" class="btn btn-primary btn-block">ขอเปลี่ยนรหัสผ่านใหม่</button>
                </div>
            </div>
            <div class="row" style="margin-top:10px;">
                <div class="col-md-12" id="submitGroup">
                    <a class="btn btn-default btn-block" href="/">กลับ</a>
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
/* Live citizenID validation */
$("#citizenid").keyup(function(){
    if(checkCitizenID($("#citizenid").val())){
        $("#citizenidGroup").removeClass("has-warning");
        $("#citizenidGroup > .help-block > .fa").remove();
    }else{
        $("#citizenidGroup").addClass("has-warning");
        $("#citizenidGroup > .help-block > .fa").remove();
        $("#citizenidGroup > .help-block").prepend("<i class=\"fa fa-exclamation-circle\"></i> ");
    }
});
</script>
@endsection
