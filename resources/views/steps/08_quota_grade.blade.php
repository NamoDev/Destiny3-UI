@extends('layouts.master')
@section('title', 'ประวัติผลการเรียน')

@section('content')
<legend><i class="fa fa-list"></i> ประวัติผลการเรียน <i class="fa fa-spinner fa-spin text-muted pull-right" style="display:none;" id="loadingSpinner"></i></legend>

<div id="subjectsContainer">
    <div class="row">
        <div class="col-md-4">
            <select class="form-control select select-primary select-block mbl">
                <option value="sci">ว (วิทยาศาสตร์)</option>
                <option value="mat">ค (คณิตศาสตร์)</option>
                <option value="eng">อ (ภาษาอังกฤษ)</option>
                <option value="tha">ท (ภาษาไทย)</option>
                <option value="soc">ส (สังคมศึกษา)</option>
            </select>
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control" placeholder="รหัสวิชา"></text>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" placeholder="คะแนนเฉลี่ยสะสม (เกรด)"></text>
        </div>
        <div class="col-xs-1">

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <a href="#" id="btnAddSubject" class="btn btn-success"><i class="fa fa-plus-circle"></i> เพิ่มรายวิชา</a>
    </div>
</div>

<div class="row">
    <div class="col-xs-6 col-md-8">
        <span id="formAlertMessage" style="display:none;"></span>
    </div>
    <div class="col-xs-6 col-md-4">
        <button id="sendTheFormButton" class="btn btn-block btn-info">บันทึกข้อมูล</button>
    </div>
</div>
@endsection

@section("additional_scripts")
<script>

var currentSubject = 1;

$("#btnAddSubject").click(function(e){
    e.preventDefault();
    $("#subjectsContainer").append(" \
    <div class=\"row dgrp\"> \
        <div class=\"col-md-4\"> \
            <select id=\"grpsel_" + currentSubject + "\" class=\"form-control select select-primary select-block mbl\"> \
                <option value=\"sci\">ว (วิทยาศาสตร์)</option> \
                <option value=\"mat\">ค (คณิตศาสตร์)</option> \
                <option value=\"eng\">อ (ภาษาอังกฤษ)</option> \
                <option value=\"tha\">ท (ภาษาไทย)</option> \
                <option value=\"soc\">ส (สังคมศึกษา)</option> \
            </select> \
        </div> \
        <div class=\"col-md-4\"> \
            <input type=\"text\" class=\"form-control\" placeholder=\"รหัสวิชา\"></text> \
        </div> \
        <div class=\"col-md-3\"> \
            <input type=\"text\" class=\"form-control\" placeholder=\"คะแนนเฉลี่ยสะสม (เกรด)\"></text> \
        </div> \
        <div class=\"col-xs-1\"> \
            <a href='#' class='btnDeleteRow'><i class='fa fa-trash fa-2x'></i></a> \
        </div> \
    </div> \
    ");

    $("#grpsel_" + currentSubject).select2();
    currentSubject++;

});

$('#subjectsContainer').on('click', '.btnDeleteRow', function(e){
    e.preventDefault();
    $(this).closest('.dgrp').remove();
})

</script>
@endsection
