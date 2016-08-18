@extends('layouts.no_navbar')
@section('title', 'สมัครใหม่')


@section('content')
<div class="row" style="margin-top:80px;">
    <div class="col-md-12">
        <h2>สมัครใหม่</h2>
        <br />
        <div class="flat-well">
          <legend>ข้อมูลส่วนตัว</legend>
          <div class="row">
            <div class="col-md-2 col-xs-4">
              <span class="help-block">คำนำหน้าชื่อ</span>
              <select id="title" name="title" class="form-control select select-primary select-block mbl">
                <optgroup label="คำนำหน้าชื่อ">
                  <option value="0">ด.ช.</option>
                  <option value="1">ด.ญ.</option>
                  <option value="2">นาย</option>
                  <option value="3">นางสาว</option>
                  <option value="4">อื่นๆ</option>
                </optgroup>
              </select>
            </div>
            <div class="col-md-4 col-md-offset-1 col-xs-8" id="fnameGroup">
              <span class="help-block">ชื่อ</span>
              <input id="fname" name="fname" type="text" placeholder="ชื่อ" class="form-control" />
            </div>
            <div class="col-md-5 col-xs-12" id="lnameGroup">
              <span class="help-block">นามสกุล</span>
              <input id="lname" name="lname" type="text" placeholder="นามสกุล" class="form-control" />
            </div>
          </div>
          <!-- == -->
          <div class="row">
            <div class="col-md-2 col-xs-4">
              <!-- Hidden: english title text. Box here will appear only if the title is selected as "other" -->
            </div>
            <div class="col-md-4 col-md-offset-1 col-xs-8" id="fname_enGroup">
              <span class="help-block">ชื่อ (ภาษาอังกฤษ)</span>
              <input id="fname_en" name="fname_en" type="text" placeholder="First name" class="form-control" />
            </div>
            <div class="col-md-5 col-xs-12" id="lname_enGroup">
              <span class="help-block">นามสกุล (ภาษาอังกฤษ)</span>
              <input id="lname_en" name="lname_en" type="text" placeholder="Last name" class="form-control" />
            </div>
          </div>
          <!-- == -->
          <div class="row">
            <div class="col-md-12" id="citizenidGroup">
              <span class="help-block">รหัสประจำตัวประชาชน</span>
              <input id="citizenid" name="citizenid" type="text" placeholder="รหัสประจำตัวประชาชน 13 หลัก" class="form-control" />
            </div>
          </div>
          <!-- == -->
          <div class="row">
            <div class="col-md-12">
              <span class="help-block">วัน เดือน ปีเกิด</span>
              <div class="row">
                <div class="col-xs-4">
                  <select id="birthdate" name="birthdate" class="form-control select select-primary select-block mbl">
                    <?php
                    $date = 1;
                    while($date <= 31){
                      echo("<option value=\"$date\">$date</option>");
                      $date++;
                    }
                     ?>
                  </select>
                </div>
                <div class="col-xs-4">
                  <select id="birthmonth" name="birthmonth" class="form-control select select-primary select-block mbl">
                    <option value="1">มกราคม</option>
                    <option value="2">กุมภาพันธ์</option>
                    <option value="3">มีนาคม</option>
                    <option value="4">เมษายน</option>
                    <option value="5">พฤษภาคม</option>
                    <option value="6">มิถุนายน</option>
                    <option value="7">กรกฎาคม</option>
                    <option value="8">สิงหาคม</option>
                    <option value="9">กันยายน</option>
                    <option value="10">ตุลาคม</option>
                    <option value="11">พฤศจิกายน</option>
                    <option value="12">ธันวาคม</option>
                  </select>
                </div>
                <div class="col-xs-4">
                  <select id="birthyear" name="birthyear" class="form-control select select-primary select-block mbl">
                    <?php
                    $year = date("Y") + 543; // Assuming that "date" will be in Christian Era.
                    $threshold = 30;
                    while($threshold >= 0){
                      echo("<option value=\"$year\">$year</option>");
                      $year -= 1;
                      $threshold -= 1;
                    }
                     ?>
                  </select>
                </div>
              </div>
            </div>
          </div>

        </div>
        <br />
        <div class="flat-well">
          <legend>ข้อมูลผู้ใช้</legend>
          <div class="row">
            <div class="col-md-12" id="emailGroup">
              <span class="help-block">E-mail address</span>
              <input id="email" name="email" type="email" placeholder="ที่อยู่อีเมล์ของนักเรียน" class="form-control" />
            </div>
          </div>
          <div class="row">
            <div class="col-md-12" id="phoneGroup">
              <span class="help-block">หมายเลขโทรศัพท์</span>
              <input id="phone" name="phone" type="text" placeholder="หมายเลขโทรศัพท์ของนักเรียน" class="form-control" />
            </div>
          </div>
          <div class="row">
            <div class="col-md-6" id="passwordGroup">
              <span class="help-block">รหัสผ่าน</span>
              <input id="password" name="password" type="password" placeholder="กำหนดรหัสผ่าน" class="form-control" />
            </div>
            <div class="col-md-6" id="password_confirmGroup">
              <span class="help-block">ยืนยันรหัสผ่าน</span>
              <input id="password_confirm" name="password_confirm" type="password" placeholder="กำหนดรหัสผ่านอีกครั้ง" class="form-control" />
            </div>
          </div>
        </div>
        <br />
        <a id="create_account" href="#" class="btn btn-primary btn-block btn-lg">สร้างบัญชีผู้สมัคร</a>
        <br />
        <a href="/" class="btn btn-default btn-block btn-lg">กลับไปหน้าหลัก</a>
        <br />
    </div>
</div>
@endsection

@section('additional_scripts')
<script>

$(function(){
  $("select").select2({dropdownCssClass: 'dropdown-inverse'});
})

$("#create_account").click(function(e){

  e.preventDefault();

  // We're submitting. Check sanity of data.
  var hasErrors = 0;

  // First, check email:
  if(checkEmail($("#email").val())){
    $("#emailGroup").removeClass("has-error");
    hasErrors -= 1;
  }else{
    $("#emailGroup").addClass("has-error");
    hasErrors += 1;
  }

  // Check citizen ID:
  if(checkCitizenID($("#citizenid").val())){
    $("#citizenidGroup").removeClass("has-error");
    hasErrors -= 1;
  }else{
    $("#citizenidGroup").addClass("has-error");
    hasErrors += 1;
  }

  // Check password:
  var pswdInput = $("#password").val();
  var pswdConfirmInput = $("#password_confirm").val();
  if(pswdInput == pswdConfirmInput){
    $("#passwordGroup").removeClass("has-error");
    $("#password_confirmGroup").removeClass("has-error");
    hasErrors -= 1;
  }else{
    $("#passwordGroup").addClass("has-error");
    $("#password_confirmGroup").addClass("has-error");
    hasErrors += 1;
  }

})

function checkEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}

function checkCitizenID(id){
  if(id.length != 13){
    return false;
  }else{
    for(i=0, sum=0; i < 12; i++)
    sum += parseFloat(id.charAt(i))*(13-i);
    if((11-sum%11)%10!=parseFloat(id.charAt(12))){
      return false;
    }else{
      return true;
    }
  }

}
</script>
@endsection
