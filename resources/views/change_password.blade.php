@extends('layouts.master')
@section('title', 'หน้าหลัก')

@section('content')

<legend>เปลี่ยนรหัสผ่าน</legend>
<div class="row">
  <div class="col-md-12" id="oldPasswordGroup">
    <span class="help-block">รหัสผ่านปัจจุบัน</span>
    <input id="oldPassword" name="oldPassword" type="password" placeholder="ใส่รหัสผ่านปัจจุบันของนักเรียน" class="form-control" />
  </div>
</div>
<div class="row">
  <div class="col-md-6" id="passwordGroup">
    <span class="help-block">รหัสผ่านใหม่</span>
    <input id="password" name="password" type="password" placeholder="กำหนดรหัสผ่าน" class="form-control" />
  </div>
  <div class="col-md-6" id="password_confirmGroup">
    <span class="help-block">ยืนยันรหัสผ่านใหม่</span>
    <input id="password_confirm" name="password_confirm" type="password" placeholder="กำหนดรหัสผ่านอีกครั้ง" class="form-control" />
  </div>
</div>

@endsection
