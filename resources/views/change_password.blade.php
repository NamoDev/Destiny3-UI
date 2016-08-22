@extends('layouts.master')
@section('title', 'หน้าหลัก')

@section('content')

<legend><i class="fa fa-key"></i> เปลี่ยนรหัสผ่าน</legend>
<div class="row">
  <div class="col-md-12" id="oldPasswordGroup">
    <span class="help-block">รหัสผ่านปัจจุบัน</span>
    <input id="oldPassword" name="oldPassword" type="password" placeholder="ใส่รหัสผ่านปัจจุบันของนักเรียน" class="form-control" required />
  </div>
</div>
<div class="row">
  <div class="col-md-6" id="passwordGroup">
    <span class="help-block">รหัสผ่านใหม่</span>
    <input id="password" name="password" type="password" placeholder="กำหนดรหัสผ่าน" class="form-control" required />
  </div>
  <div class="col-md-6" id="password_confirmGroup">
    <span class="help-block">ยืนยันรหัสผ่านใหม่</span>
    <input id="password_confirm" name="password_confirm" type="password" placeholder="กำหนดรหัสผ่านอีกครั้ง" class="form-control" required />
  </div>
</div>
<br />
<div class="row">
  <div class="col-md-12">
    <a class="btn btn-lg btn-block btn-success" href="#" id="submitButton">เปลี่ยนรหัสผ่าน</a>
  </div>
</div>

@endsection

@section('additional_scripts')
<script>

  $("#submitButton").click(function(e){
    e.preventDefault();
    /* TODO: Add submission code */
  });

  /* Live password validation */
  $("#password").keyup(function() {
    checkPasswordFields();
  });
  $("#password_confirm").keyup(function() {
    checkPasswordFields();
  });

  function checkPasswordFields(){
    var pswdInput = $("#password").val();
    var pswdConfirmInput = $("#password_confirm").val();
    if(pswdInput == pswdConfirmInput){
      $("#passwordGroup").removeClass("has-warning");
      $("#password_confirmGroup").removeClass("has-warning");
    }else{
      $("#passwordGroup").addClass("has-warning");
      $("#password_confirmGroup").addClass("has-warning");
    }
  }
</script>
@endsection
