@extends('layouts.welcome')
@section('title', 'หน้าหลัก')

@section('content')

<div class="row">
    <div class="col-xs-12 text-center">
        <hr />
        <!--
        TODO: Again, add the real thing. Also need to complete the event countdown code first.
        Unfortunately, I forgot to bring PHP documentations onboard. Coding is hard at 35,000 feet!
        -->
        <h4>เหลือเวลาอีก <b>17</b> วัน <b>เปิดรับสมัครนักเรียนโควตาจังหวัด</b></h4>
        <hr />
        <br />
    </div>
</div>

<!-- TODO: Clean this up... -->
<div class="row">
              <!-- ===== -->
              <div class="col-md-4">
                  <a href="/application/begin" target="_self">
                  <div class="well btnWell btnWellWithBgColor">
                      <h2><i class="fa fa-edit text-muted"></i> สมัครใหม่</h2>
                      <h5>สำหรับนักเรียนที่ยังไม่เคยใช้งานระบบมาก่อน</h5>
                  </div>
                  </a>
              </div>
              <!-- ===== -->
              <div class="col-md-4">
                  <a href="/login" target="_self">
                  <div class="well btnWell btnWellWithBgColor">
                      <h2><i class="fa fa-sign-in text-muted"></i> เข้าสู่ระบบ</h2>
                      <h5>สำหรับนักเรียนที่เคยกรอกข้อมูลแล้ว</h5>
                  </div>
                  </a>
              </div>
              <!-- ===== -->
              <div class="col-md-4">
                  <a href="/help" target="_self">
                  <div class="well btnWell btnWellWithBgColor">
                      <h2><i class="fa fa-life-ring text-muted"></i> ช่วยเหลือ</h2>
                      <h5>ในกรณีที่เกิดปัญหาในการสมัคร</h5>
                  </div>
                  </a>
              </div>
              <!-- ===== -->
</div>

<!-- TODO: Also clean this up... -->
<div class="row">
              <hr />
              <div class="col-md-7">
                  <div class="well">
                      <legend><i class="fa fa-bullhorn"></i> ประกาศ</legend>
                  </div>
              </div>
              <div class="col-md-5">
                  <div class="well">
                      <!-- TODO: Implement a CMS-style feature here maybe? -->
                      <legend><i class="fa fa-download"></i> ดาวน์โหลด</legend>
                      <a class="btn btn-block btn-primary">ประกาศฉบับที่หนึ่ง</a>
                      <a class="btn btn-block btn-primary">ประกาศฉบับที่สอง</a>
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

@endsection
