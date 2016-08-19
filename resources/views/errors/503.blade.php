@extends('layouts.no_navbar')
@section('title', '503')

@section('content')

<div class="row" style="margin-top:120px;">
    <div class="col-md-8 col-md-offset-2">
        <div class="row">
            <div class="col-sm-4">
                <img src="/assets/images/woah.png" alt="O NOES" width="200px" />
            </div>
            <div class="col-sm-8">
                <h3 style="margin-top:80px;">ระบบปิดชั่วคราว กรุณากลับมาใหม่อีกครั้งภายหลัง</h3>
                <br />
                <a href="/" class="btn btn-warning" target="_self">&nbsp;&nbsp;&nbsp;&nbsp;กลับไปหน้าหลัก&nbsp;&nbsp;&nbsp;&nbsp;</a>
            </div>
        </div>
    </div>
</div>

@endsection
