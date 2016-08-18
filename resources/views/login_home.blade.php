@extends('layouts.no_navbar')
@section('title', 'หน้าหลัก')

@section('content')

<div class="row" style="margin-top:80px;">
    <div class="col-md-12">
        <h1>ระบบรับสมัครนักเรียน<br />โรงเรียนเตรียมอุดมศึกษา</h1>
        <h4>// ปีการศึกษา 2560</h4>
    </div>
</div>

<div class="row" style="margin-top:10px;">
    <div class="col-md-12">
        <a href="#">
        <div class="alert alert-success">
            <i class="fa fa-calendar"></i> <b>เหลืออีก 17 วัน</b> เปิดรับสมัครนักเรียนในระบบโควตาจังหวัด
        </div>
        </a>
    </div>
</div>

<div class="row" style="margin-top:15px;">
    <div class="col-md-6">
        <form class="login-form" method="POST" action="/login">
            <legend>เข้าสู่ระบบ</legend>
            <div class="form-group">
                <input type="text" class="form-control login-field" value="" placeholder="รหัสประจำตัวประชาชน" id="login-id" />
                <label class="login-field-icon fui-user" for="login-name"></label>
            </div>

            <div class="form-group">
                <input type="password" class="form-control login-field" value="" placeholder="รหัสผ่าน" id="login-password" />
                <label class="login-field-icon fui-lock" for="login-pass"></label>
            </div>

            <button class="btn btn-primary btn-lg btn-block" type="submit">เข้าสู่ระบบ</button>
            <a class="login-link" href="/iforgot">ลืมรหัสผ่าน?</a>
        </form>
    </div>
    <div class="col-md-6">
        <div class="login-form">
            <legend>ยังไม่เคยลงทะเบียน?</legend>
            <a class="btn btn-primary btn-lg btn-block" href="/application/begin">สมัครใหม่</a>
        </div>
        <div class="login-form" style="margin-top:10px;">
            <legend>ปัญหาในการสมัคร?</legend>
            <div class="row">
                <div class="col-xs-6">
                    <a class="btn btn-primary btn-lg btn-block" href="/faq">คำถามที่พบบ่อย</a>
                </div>
                <div class="col-xs-6">
                    <a class="btn btn-primary btn-lg btn-block" href="/contact">ติดต่อเจ้าหน้าที่</a>
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
