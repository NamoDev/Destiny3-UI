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
            <div class="col-md-4 col-md-offset-1 col-xs-8">
              <span class="help-block">ชื่อ</span>
              <input id="fname" name="fname" type="text" placeholder="ชื่อ" class="form-control" />
            </div>
            <div class="col-md-5 col-xs-12">
              <span class="help-block">นามสกุล</span>
              <input id="lname" name="lname" type="text" placeholder="นามสกุล" class="form-control" />
            </div>
          </div>
          <!-- == -->
          <div class="row">
            <div class="col-md-2 col-xs-4">
              <!-- Hidden: english title text. Box here will appear only if the title is selected as "other" -->
            </div>
            <div class="col-md-4 col-md-offset-1 col-xs-8">
              <span class="help-block">นามสกุล (ภาษาอังกฤษ)</span>
              <input id="fname_en" name="fname_en" type="text" placeholder="First name" class="form-control" />
            </div>
            <div class="col-md-5 col-xs-12">
              <span class="help-block">นามสกุล (ภาษาอังกฤษ)</span>
              <input id="lname_en" name="lname_en" type="text" placeholder="Last name" class="form-control" />
            </div>
          </div>
          <!-- == -->
          <div class="row">
            <div class="col-md-12">
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
    </div>
</div>
@endsection

@section('additional_scripts')
<script>
$(function(){
  $("select").select2({dropdownCssClass: 'dropdown-inverse'});
})
</script>
@endsection
