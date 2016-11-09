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
                    <i class="fa fa-times-circle text-danger fa-4x"></i><br /><br />
                    @if(Session::has('message'))
                        {{ Session::get('message') }}
                    @else
                        เกิดข้อผิดพลาดระหว่างประมวลผลคำขอ กรุณาลองใหม่อีกครั้ง
                    @endif
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
