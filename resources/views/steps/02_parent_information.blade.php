@extends('layouts.master')

@section('title', 'ข้อมูลผู้ปกครอง')

@section('content')
<legend><i class="fa fa-user-plus"></i> ข้อมูลผู้ปกครอง <i class="fa fa-spinner fa-spin text-muted pull-right" style="display:none;" id="loadingSpinner"></i></legend>

<div class="row">
    <div class="col-xs-12">
        <p class="badge" style="font-size:.9em;font-weight:normal;">&nbsp;&nbsp; บิดา &nbsp;&nbsp;</p>
        <div class="row">
            <div class="col-md-3 col-xs-4">
                <span class="help-block">คำนำหน้าชื่อ</span>
                <input id="father_title" name="father_title" type="text" placeholder="คำนำหน้าชื่อ" class="form-control" />
            </div>
            <div class="col-md-4 col-xs-8" id="fnameGroup">
                <span class="help-block">ชื่อ</span>
                <input id="father_fname" name="father_fname" type="text" placeholder="ชื่อ" class="form-control" />
            </div>
            <div class="col-md-5 col-xs-12" id="lnameGroup">
                <span class="help-block">นามสกุล</span>
                <input id="father_lname" name="father_lname" type="text" placeholder="นามสกุล" class="form-control" />
            </div>
        </div>
    </div>
</div>

@endsection

@section('additional_scripts')

@endsection
