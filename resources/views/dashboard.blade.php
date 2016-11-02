@extends('layouts.master')
@section('title', 'หน้าหลัก')

@section('content')
<div class="row">
    <div class="col-md-3">
        <span class="help-block" style="font-size:1em;">เลขที่นั่งสอบ</span>
        <h4 class="text-muted" style="margin-top:0px;">---</h4>
    </div>
    <div class="col-md-5">
        <span class="help-block" style="font-size:1em;">สถานที่สอบ</span>
        <h4 class="text-muted" style="margin-top:0px;">---</h4>
    </div>
    <div class="col-md-2">
        <span class="help-block" style="font-size:1em;">อาคาร</span>
        <h4 class="text-muted" style="margin-top:0px;">---</h4>
    </div>
    <div class="col-md-2">
        <span class="help-block" style="font-size:1em;">ห้อง</span>
        <h4 class="text-muted" style="margin-top:0px;">---</h4>
    </div>
</div>
@endsection
