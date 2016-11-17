@extends('layouts.master')
@section('title', 'ประวัติผลการเรียน')

@section('content')
<legend><i class="fa fa-list"></i> ประวัติผลการเรียน <i class="fa fa-spinner fa-spin text-muted pull-right" style="display:none;" id="loadingSpinner"></i></legend>

@for($i=0;$i<3;$i++)
<div class="row">
    <div class="col-xs-12 col-md-4">
        <select class="form-control select select-primary select-block mbl">
            <option value="s">ว (วิทยาศาสตร์)</option>
            <option value="s">ค (คณิตศาสตร์)</option>
            <option value="s">ส (สังคมศึกษา)</option>
            <option value="s">ท (ภาษาไทย)</option>
            <option value="s">อ (ภาษาอังกฤษ)</option>
        </select>
    </div>
    <div class="col-xs-12 col-md-4">
        <input type="text" class="form-control" placeholder="รหัสวิชา"></text>
    </div>
    <div class="col-xs-12 col-md-4">
        <input type="text" class="form-control" placeholder="เกรด"></text>
    </div>
</div>
@endfor


<div class="row">
    <div class="col-xs-6 col-md-8">
        <span id="formAlertMessage" style="display:none;"></span>
    </div>
    <div class="col-xs-6 col-md-4">
        <button id="sendTheFormButton" class="btn btn-block btn-info">บันทึกข้อมูล</button>
    </div>
</div>
@endsection
