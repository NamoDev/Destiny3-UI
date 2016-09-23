@extends('layouts.master')

@section('title', 'ที่อยู่และภูมิลำเนา')

@section('content')
<legend><i class="fa fa-map-marker"></i> ที่อยู่และภูมิลำเนา <i class="fa fa-spinner fa-spin text-muted pull-right" style="display:none;" id="loadingSpinner"></i></legend>
<div class="row">
    <div class="col-xs-12">
        <p class="badge" style="font-size:.9em;font-weight:normal;">&nbsp;&nbsp; ที่อยู่ตามทะเบียนบ้าน &nbsp;&nbsp;</p>
        <div class="row">
            <div class="col-md-3 col-xs-4">
                <span class="help-block">บ้านเลขที่</span>
                <input name="home_address" type="text" placeholder="บ้านเลขที่" class="form-control">
            </div>
            <div class="col-md-3 col-xs-4">
                <span class="help-block">หมู่</span>
                <input name="home_moo" type="text" placeholder="หากไม่มีให้ใส่ขีด (-)" class="form-control">
            </div>
            <div class="col-md-3 col-xs-4">
                <span class="help-block">ซอย</span>
                <input name="home_soi" type="text" placeholder="หากไม่มีให้ใส่ขีด (-)" class="form-control">
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-xs-4">
                <span class="help-block">ถนน</span>
                <input name="home_road" type="text" placeholder="หากไม่มีให้ใส่ขีด (-)" class="form-control">
            </div>
            <div class="col-md-3 col-xs-4">
                <span class="help-block">แขวง / ตำบล</span>
                <input name="home_subdistrict" type="text" placeholder="หากไม่มีให้ใส่ขีด (-)" class="form-control">
            </div>
            <div class="col-md-3 col-xs-4">
                <span class="help-block">เขต / อำเภอ</span>
                <input name="home_district" type="text" placeholder="หากไม่มีให้ใส่ขีด (-)" class="form-control">
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <p class="badge" style="font-size:.9em;font-weight:normal;">&nbsp;&nbsp; ที่อยู่ปัจจุบัน &nbsp;&nbsp;</p>
        <div class="row">
            <div class="col-md-3 col-xs-4">
                <span class="help-block">บ้านเลขที่</span>
                <input name="current_address" type="text" placeholder="บ้านเลขที่" class="form-control">
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional_scripts')

@endsection
