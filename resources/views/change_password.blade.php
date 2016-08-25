@extends('layouts.master')
@section('title', 'หน้าหลัก')

@section('content')

<legend><i class="fa fa-key"></i> เปลี่ยนรหัสผ่าน</legend>
<div class="row">
  <div class="col-md-12" id="old_passwordGroup">
    <span class="help-block">รหัสผ่านปัจจุบัน</span>
    <input id="old_password" name="old_password" type="password" placeholder="ใส่รหัสผ่านปัจจุบันของนักเรียน" class="form-control" required />
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

    var hasErrors = 0;
    var pswdInput = $("#password").val();
    var pswdConfirmInput = $("#password_confirm").val();

    if(pswdInput == pswdConfirmInput){
        if(pswdInput != '' && pswdConfirmInput != ''){
            $("#passwordGroup").removeClass("has-error");
            $("#password_confirmGroup").removeClass("has-error");
        }else{
            $("#passwordGroup").addClass("has-error");
            $("#password_confirmGroup").addClass("has-error");
            hasErrors += 1;
        }
    }else{
      $("#passwordGroup").addClass("has-error");
      $("#password_confirmGroup").addClass("has-error");
      hasErrors += 1;
    }

    if(hasErrors == 0){

      //Init AJAX!
      $.ajax({
        url: '/api/v1/account/change_password',
        data: {
           _token: csrfToken,
           old_password: $("#old_password").val(),
           password: $("#password").val(),
           password_confirm: $("#password_confirm").val()
        },
        error: function (request, status, error) {
            $('#plsWaitModal').modal('hide');
            console.log(request.responseText);
            switch(request.status){
                case 401:
                    bootbox.alert("Unauthorized");
                break;
                case 422:
                    bootbox.alert("มีข้อผิดพลาดของข้อมูล โปรดตรวจสอบรูปแบบข้อมูลอีกครั้ง");
                break;
                default:
                    bootbox.alert("เกิดข้อผิดพลาดในการส่งข้อมูล กรุณาลองใหม่อีกครั้ง");
            }
        },
        dataType: 'json',
        success: function(data) {
          console.log("AJAX complete");
        },
        type: 'POST'
     });
    }else{
      // NOPE.
      $('#plsWaitModal').modal('hide');
      bootbox.alert("มีข้อผิดพลาดของข้อมูล โปรดตรวจสอบรูปแบบข้อมูลอีกครั้ง");
    }

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
