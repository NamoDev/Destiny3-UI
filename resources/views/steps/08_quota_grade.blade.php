@extends('layouts.master')
@section('title', 'ประวัติผลการเรียน')

@section('content')
<legend><i class="fa fa-list"></i> ประวัติผลการเรียน <i class="fa fa-spinner fa-spin text-muted pull-right" style="display:none;" id="loadingSpinner"></i></legend>

<div id="subjectsContainer">
    <div class="row">
        <div class="col-md-4" id="grpsel_0Group">
            <select id="grpsel_0" class="form-control select select-primary select-block mbl">
                <option value="sci">ว (วิทยาศาสตร์)</option>
                <option value="mat">ค (คณิตศาสตร์)</option>
                <option value="eng">อ (ภาษาอังกฤษ)</option>
                <option value="tha">ท (ภาษาไทย)</option>
                <option value="soc">ส (สังคมศึกษา)</option>
            </select>
        </div>
        <div class="col-md-4" id="code_0Group">
            <input id="code_0" type="text" class="form-control" placeholder="รหัสวิชา"></text>
        </div>
        <div class="col-md-3" id="grade_0Group">
            <input id="grade_0" type="text" class="form-control" placeholder="คะแนนเฉลี่ยสะสม (เกรด)"></text>
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

<br />
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
var gpaPattern = new RegExp("[1-4].[0-9]{2}");

$("#btnAddSubject").click(function(e){
    e.preventDefault();
    $("#subjectsContainer").append(" \
    <div class=\"row dgrp\"> \
        <div class=\"col-md-4\" id=\"grpsel_" + currentSubject + "Group\"> \
            <select id=\"grpsel_" + currentSubject + "\" class=\"form-control select select-primary select-block mbl\"> \
                <option value=\"sci\">ว (วิทยาศาสตร์)</option> \
                <option value=\"mat\">ค (คณิตศาสตร์)</option> \
                <option value=\"eng\">อ (ภาษาอังกฤษ)</option> \
                <option value=\"tha\">ท (ภาษาไทย)</option> \
                <option value=\"soc\">ส (สังคมศึกษา)</option> \
            </select> \
        </div> \
        <div class=\"col-md-4\" id=\"code_" + currentSubject +  "Group\"> \
            <input type=\"text\" id=\"code_" + currentSubject +  "\" class=\"form-control\" placeholder=\"รหัสวิชา\"></text> \
        </div> \
        <div class=\"col-md-3\" id=\"grade_" + currentSubject +  "Group\"> \
            <input type=\"text\" id=\"grade_" + currentSubject +  "\" class=\"form-control\" placeholder=\"คะแนนเฉลี่ยสะสม (เกรด)\"></text> \
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
});

$("#sendTheFormButton").click(function(e){
    e.preventDefault();
    $('#plsWaitModal').modal('show');

    var looper = 0;
    var hasErrors = 0;
    var dataToSend = {
        _token: csrfToken
    };

    while(looper < currentSubject){
        // Check for input
        hasErrors += isFieldBlank("code_" + looper);
        hasErrors += isFieldBlank("grade_" + looper);

        if(isNaN($("#grade_" + looper).val())){
            hasErrors++;
            $("#grade_" + looper + "Group").addClass("has-error");
        }
        if(parseFloat($("#grade_" + looper).val()) > 4 || parseFloat($("#grade_" + looper).val()) <= 0){
            // Error!
            hasErrors++;
            $("#grade_" + looper + "Group").addClass("has-error");
        }
        if(!gpaPattern.test($("#grade_" + looper).val())){
            hasErrors++;
            $("#grade_" + looper + "Group").addClass("has-error");
        }

        dataToSend[looper] = {
            "subject": $("#grpsel_" + looper).val(),
            "code": $("#code_" + looper).val(),
            "grade": $("#grade_" + looper).val(),
        };

        looper++;
    }

    // Ready. Are there any errors?
    if(hasErrors == 0){
        // We're all good!
        $.ajax({
            url: '/api/v1/applicant/grade',
            data: dataToSend,
            error: function (request, status, error) {
                $('#plsWaitModal').modal('hide');
                switch(request.status){
                    case 422:
                        notify("<i class='fa fa-exclamation-triangle text-warning'></i> มีข้อผิดพลาดของข้อมูล โปรดตรวจสอบรูปแบบข้อมูลอีกครั้ง", "warning");
                    break;
                    default:
                        console.log("(" + request.status + ") Exception:" + request.responseText);
                        notify("<i class='fa fa-exclamation-triangle text-warning'></i> เกิดข้อผิดพลาดในการส่งข้อมูล กรุณาลองใหม่อีกครั้ง", "danger");
                }
            },
            dataType: 'json',
            success: function(data) {

                // Tell the user that everything went well
                $('#plsWaitModal').modal('hide');
                notify("<i class='fa fa-check'></i> บันทึกข้อมูลเรียบร้อย", "success");

            },
            type: 'POST'
        });
    }else{
        // O NOES!
        $('#plsWaitModal').modal('hide');
        notify("<i class='fa fa-exclamation-triangle text-warning'></i> มีข้อผิดพลาดของข้อมูล โปรดตรวจสอบรูปแบบข้อมูลอีกครั้ง", "warning");
    }

    console.log(dataToSend);

});

</script>
@endsection
