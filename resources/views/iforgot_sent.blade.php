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
        <div class="flat-well">
            <div class="row">
                <div class="col-md-12 text-center">
                    <i class="fa fa-check-circle text-success fa-4x"></i><br /><br />
                    ระบบได้ทำการส่งขั้นตอนการตั้งรหัสผ่านใหม่ไปยัง email ของผู้สมัครแล้ว<br />
                    กรุณาทำตามขั้นตอนที่ระบุไว้ใน email เพื่อตั้งค่ารหัสผ่านใหม่<br /><br />
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-primary btn-block" href="/">กลับ</a>
                </div>
            </div>
        </div>
    </div>
</div>
{{ csrf_field() }}
</form>
@endsection
