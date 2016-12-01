@extends('layouts.master')
@section('title', 'ประวัติผลการเรียน')

<?php $subjectCounter = 1; ?>

@section('content')
<legend><i class="fa fa-list"></i> ประวัติผลการเรียน <i class="fa fa-spinner fa-spin text-muted pull-right" style="display:none;" id="loadingSpinner"></i></legend>

<div id="subjectsContainer">
    <div class="row dgrp" id="dgrp_0">
        <div class="col-md-4" id="grpsel_0Group">
            <select id="grpsel_0" class="form-control select select-primary select-block mbl">
                <?php
                    $subjects = [
                        "sci" => "ว (วิทยาศาสตร์)",
                        "mat" => "ค (คณิตศาสตร์)",
                        "eng" => "อ (ภาษาอังกฤษ)",
                        "tha" => "ท (ภาษาไทย)",
                        "soc" => "ส (สังคมศึกษา)",
                    ];
                    if(isset($applicantData['quota_grade'][0])){
                        foreach($subjects as $key => $subject){
                            if($key == $applicantData['quota_grade'][0]['subject']){
                                echo("<option value=\"$key\" selected>$subject</option>");
                            }else{
                                echo("<option value=\"$key\">$subject</option>");
                            }
                        }
                    }else{
                        foreach($subjects as $key => $subject){
                            echo("<option value=\"$key\">$subject</option>");
                        }
                    }
                 ?>
            </select>
        </div>
        <div class="col-md-4" id="code_0Group">
            <input id="code_0" type="text" class="form-control" placeholder="รหัสวิชา (ไม่ต้องใส่ตัวอักษร)" value="{{isset($applicantData['quota_grade'][0]['code']) ? $applicantData['quota_grade'][0]['code'] : ''}}"></text>
        </div>
        <div class="col-md-3" id="grade_0Group">
            <input id="grade_0" type="text" class="form-control" placeholder="เกรด (กรอกในรูปแบบ 4.00)" value="{{isset($applicantData['quota_grade'][0]['grade']) ? $applicantData['quota_grade'][0]['grade'] : ''}}"></text>
        </div>
        <div class="col-xs-1">

        </div>
    </div>
    @if(isset($applicantData['quota_grade']))
        @if(count($applicantData['quota_grade']) > 1)
            <?php
                $remainingSubjects = $applicantData['quota_grade'];
                array_shift($remainingSubjects);
            ?>
            @foreach($remainingSubjects as $subjectNode)
                <div class="row dgrp" id="dgrp_{{$subjectCounter}}">
                    <div class="col-md-4" id="grpsel_{{$subjectCounter}}Group">
                        <select id="grpsel_{{$subjectCounter}}" class="form-control select select-primary select-block mbl">
                            <?php
                                $subjects = [
                                    "sci" => "ว (วิทยาศาสตร์)",
                                    "mat" => "ค (คณิตศาสตร์)",
                                    "eng" => "อ (ภาษาอังกฤษ)",
                                    "tha" => "ท (ภาษาไทย)",
                                    "soc" => "ส (สังคมศึกษา)",
                                ];
                                if(isset($applicantData['quota_grade'][$subjectCounter])){
                                    foreach($subjects as $key => $subject){
                                        if($key == $applicantData['quota_grade'][$subjectCounter]['subject']){
                                            echo("<option value=\"$key\" selected>$subject</option>");
                                        }else{
                                            echo("<option value=\"$key\">$subject</option>");
                                        }
                                    }
                                }else{
                                    foreach($subjects as $key => $subject){
                                        echo("<option value=\"$key\">$subject</option>");
                                    }
                                }
                             ?>
                        </select>
                    </div>
                    <div class="col-md-4" id="code_{{$subjectCounter}}Group">
                        <input id="code_{{$subjectCounter}}" type="text" class="form-control codeInput" placeholder="รหัสวิชา (ไม่ต้องใส่ตัวอักษร)" value="{{isset($applicantData['quota_grade'][$subjectCounter]['code']) ? $applicantData['quota_grade'][$subjectCounter]['code'] : ''}}"></text>
                    </div>
                    <div class="col-md-3" id="grade_{{$subjectCounter}}Group">
                        <input id="grade_{{$subjectCounter}}" type="text" class="form-control gradeInput" placeholder="เกรด (กรอกในรูปแบบ 4.00)" value="{{isset($applicantData['quota_grade'][$subjectCounter]['grade']) ? $applicantData['quota_grade'][$subjectCounter]['grade'] : ''}}"></text>
                    </div>
                    <div class="col-xs-1">
                        <a href='#' class='btnDeleteRow'><i class='fa fa-trash fa-2x'></i></a>
                    </div>
                </div>
                <?php $subjectCounter++; ?>
            @endforeach
        @endif
    @endif
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

var currentSubject = {{ $subjectCounter }};
var gpaPattern = new RegExp("[1-4].[0-9]{2}");

$(function(){
    $("#grpsel_0").change();
});

$("#btnAddSubject").click(function(e){
    e.preventDefault();
    $("#subjectsContainer").append(" \
    <div class=\"row dgrp\" id=\"dgrp_" + currentSubject + "\"> \
        <div class=\"col-md-4\" id=\"grpsel_" + currentSubject + "Group\"> \
            <select id=\"grpsel_" + currentSubject + "\" class=\"form-control select select-primary select-block mbl grpsel\"> \
                <option value=\"sci\">ว (วิทยาศาสตร์)</option> \
                <option value=\"mat\">ค (คณิตศาสตร์)</option> \
                <option value=\"eng\">อ (ภาษาอังกฤษ)</option> \
                <option value=\"tha\">ท (ภาษาไทย)</option> \
                <option value=\"soc\">ส (สังคมศึกษา)</option> \
            </select> \
        </div> \
        <div class=\"col-md-4\" id=\"code_" + currentSubject +  "Group\"> \
            <input type=\"text\" id=\"code_" + currentSubject +  "\" class=\"form-control codeInput\" placeholder=\"รหัสวิชา (ไม่ต้องใส่ตัวอักษร)\"></text> \
        </div> \
        <div class=\"col-md-3\" id=\"grade_" + currentSubject +  "Group\"> \
            <input type=\"text\" id=\"grade_" + currentSubject +  "\" class=\"form-control gradeInput\" placeholder=\"เกรด (กรอกในรูปแบบ 4.00)\"></text> \
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

    $(".codeInput").each(function() {
        hasErrors += isFieldBlank("code_" + $(this).parent().prop("id"));
    });

    $(".gradeInput").each(function() {
        hasErrors += isFieldBlank("grade_" + $(this).parent().prop("id"));
    });

    $(".dgrp").each(function(){
        var currentIndex = $(this).prop('id').slice(5);

        if(isNaN($("#grade_" + currentIndex).val())){
            hasErrors++;
            $("#grade_" + currentIndex + "Group").addClass("has-error");
        }
        if(parseFloat($("#grade_" + currentIndex).val()) > 4 || parseFloat($("#grade_" + currentIndex).val()) <= 0){
            // Error!
            hasErrors++;
            $("#grade_" + currentIndex + "Group").addClass("has-error");
        }
        if(!gpaPattern.test($("#grade_" + currentIndex).val())){
            hasErrors++;
            $("#grade_" + currentIndex + "Group").addClass("has-error");
        }

        dataToSend[looper] = {
            "subject": $("#grpsel_" + currentIndex).val(),
            "code": $("#code_" + currentIndex).val(),
            "grade": $("#grade_" + currentIndex).val(),
        };

        looper++;

    });

    console.log(dataToSend);
    console.log(hasErrors);

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

                setTimeout(function(){
                     location.reload();
                }, 1500);

            },
            type: 'POST'
        });
    }else{
        // O NOES!
        $('#plsWaitModal').modal('hide');
        notify("<i class='fa fa-exclamation-triangle text-warning'></i> มีข้อผิดพลาดของข้อมูล โปรดตรวจสอบรูปแบบข้อมูลอีกครั้ง", "warning");
    }

});

</script>
@endsection
