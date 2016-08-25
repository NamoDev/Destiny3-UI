@extends('layouts.master')
@section('title', 'หน้าหลัก')

@section('content')

<div id="passwordChangeSuccessNotification" class="alert alert-dismissible alert-success" style="display:none;">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <i class="fa fa-check-circle"></i> เปลี่ยนรหัสผ่านเรียบร้อยแล้ว
</div>
<div id="alertNotification" class="alert alert-dismissible alert-warning" style="display:none;">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <i class="fa fa-exclamation-circle"></i> <span id="alertNotificationText">Uh Oh!</span>
</div>

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

    if($("#old_password").val() != ''){
        $("#old_passwordGroup").removeClass("has-error");
        $("#old_password_confirmGroup").removeClass("has-error");
    }else{
        $("#old_passwordGroup").addClass("has-error");
        $("#old_password_confirmGroup").addClass("has-error");
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
            var response = JSON.parse(request.responseText);
            switch(request.status){
                case 401:
                    if(response.result == "old_password_incorrect"){
                        $("#old_passwordGroup").addClass("has-error");
                        $("#old_password_confirmGroup").addClass("has-error");
                        raiseAlert("รหัสผ่านเก่าไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง");
                    }else{
                        raiseAlert("คุณไม่มีสิทธิ์ในดำเนินการนี้");
                    }
                break;
                case 422:
                    raiseAlert("มีข้อผิดพลาดของข้อมูล โปรดตรวจสอบรูปแบบข้อมูลอีกครั้ง");
                break;
                default:
                    raiseAlert("เกิดข้อผิดพลาดในการส่งข้อมูล กรุณาลองใหม่อีกครั้ง");
            }
        },
        dataType: 'json',
        success: function(data) {
            $("#passwordChangeSuccessNotification").fadeIn(300);
            $("#old_password").val("");
            $("#password").val("");
            $("#password_confirm").val("");
        },
        type: 'POST'
     });
    }else{
      // NOPE.
      $('#plsWaitModal').modal('hide');
      raiseAlert("มีข้อผิดพลาดของข้อมูล โปรดตรวจสอบรูปแบบข้อมูลอีกครั้ง");
    }

  });

  /* Live password validation */
  $("#password").keyup(function() {
    checkPasswordFields();
  });
  $("#password_confirm").keyup(function() {
    checkPasswordFields();
  });

  function raiseAlert(message){
      $("#alertNotificationText").html(message);
      $("#alertNotification").fadeIn(300);
  }

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
