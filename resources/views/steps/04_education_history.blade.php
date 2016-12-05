@extends('layouts.master')

@section('title', 'ประวัติการศึกษา')

@section('content')

<legend><i class="fa fa-graduation-cap"></i> ประวัติการศึกษา <i class="fa fa-spinner fa-spin text-muted pull-right" style="display:none;" id="loadingSpinner"></i></legend>

<div class="row">
    <div class="col-md-6 col-xs-12" id="school2Group">
        <span class="help-block">ศึกษา<b>ชั้นมัธยมศึกษาปีที่ 2</b> โรงเรียน</span>
        <input id="school2" name="school2" placeholder="ชื่อสถานศึกษา ( ไม่ต้องพิมพ์คำว่า 'โรงเรียน' )" class="form-control twitter-typeahead" value="{{ isset($applicantData['school2']) ? $applicantData['school2'] : ''}}" />
    </div>
    <div class="col-md-3 col-xs-12">
        <span class="help-block">ปีการศึกษา</span>
        2558
    </div>
    <div class="col-md-3 col-xs-12">
        <span class="help-block">จังหวัดที่ตั้งโรงเรียน</span>
        <select id="school2_province" name="school2_province" class="form-control select select-primary select-block mbl">
            {{ App\Http\Controllers\Helper::printProvinceOptions(isset($applicantData['school2_province']) ? $applicantData['school2_province'] : NULL) }}
        </select>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-xs-12" id="school3Group">
        <span class="help-block">กำลังศึกษา<b>ชั้นมัธยมศึกษาปีที่ 3</b> โรงเรียน</span>
        <input id="school3" name="school3" placeholder="ชื่อสถานศึกษา ( ไม่ต้องพิมพ์คำว่า 'โรงเรียน' )" class="form-control twitter-typeahead" value="{{ isset($applicantData['school']) ? $applicantData['school'] : ''}}" />
    </div>
    <div class="col-md-3 col-xs-12">
        <span class="help-block">ปีการศึกษา</span>
        2559
    </div>
    <div class="col-md-3 col-xs-12">
        <span class="help-block">จังหวัดที่ตั้งโรงเรียน</span>
        <select id="schoolProvince" name="schoolProvince" class="form-control select select-primary select-block mbl">
            {{ App\Http\Controllers\Helper::printProvinceOptions(isset($applicantData['school_province']) ? $applicantData['school_province'] : NULL) }}
        </select>
    </div>
</div>
<div class="row">
    <div class="col-md-3 col-xs-12" id="gpaGroup">
        <span class="help-block">เกรดเฉลี่ยสะสม 5 ภาคเรียน</span>
        <input id="gpa" name="gpa" type="text" placeholder="GPA ในรูปแบบ 0.00" class="form-control" value="{{ isset($applicantData['gpa']) ? $applicantData['gpa'] : ''}}" />
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

@section('additional_scripts')
<script src="/assets/js/typeahead.min.js"></script>
<script>
$("#gpa").change(function(){
    if(!isNaN(parseFloat($("#gpa").val()))){
        if(parseFloat($("#gpa").val()) > 4.0){
            $("#gpaGroup").addClass("has-warning");
            $("#gpaGroup > .help-block > .fa").remove();
            $("#gpaGroup > .help-block").prepend("<i class=\"fa fa-exclamation-circle\"></i> ");
        }else{
            $("#gpaGroup").removeClass("has-warning");
            $("#gpaGroup > .help-block > .fa").remove();
        }
    }else{
        $("#gpaGroup").addClass("has-warning");
        $("#gpaGroup > .help-block > .fa").remove();
        $("#gpaGroup > .help-block").prepend("<i class=\"fa fa-exclamation-circle\"></i> ");
    }
});

$("#sendTheFormButton").click(function(){

    // Tell the user to wait:
    $('#plsWaitModal').modal('show');

    // Error status:
    var hasErrors = 0;

    // Disallow blank fields:
    hasErrors += isFieldBlank("gpa");
    hasErrors += isFieldBlank("school2");
    hasErrors += isFieldBlank("school3");

    // Check GPA. First, see if the user has given us something higher than 4.00:
    if(!isNaN(parseFloat($("#gpa").val()))){
        if(parseFloat($("#gpa").val()) > 4.0){
            $("#gpaGroup").addClass("has-error");
            hasErrors += 1;
        }else{
            $("#gpaGroup").removeClass("has-error");
        }
    }

    // Then, see if we can match to a x.xx GPA regex:
    var gpaPattern = new RegExp("[1-4].[0-9]{2}");
    if(!gpaPattern.test($("#gpa").val())){
        // Uh-oh!
        $("#gpaGroup").addClass("has-error");
        hasErrors += 1;
    }else{
        $("#gpaGroup").removeClass("has-error");
    }

    @if(Config::get('app.debug') === true)
        // For debugging. This only comes up if we're in debug mode:
        console.log("[DBG/LOG] Total errors: " + hasErrors);
    @endif

    // Ready to send. Are there any errors?
    if(hasErrors == 0){
        // We're all good!
        $.ajax({
            url: '/api/v1/applicant/education_history',
            data: {
                _token: csrfToken,
                school2 : $("#school2").val(),
                school2_province : $("#school2_province").val(),
                school : $("#school3").val(),
                school_province : $("#schoolProvince").val(),
                gpa : $("#gpa").val()
            },
            error: function (request, status, error) {
                $('#plsWaitModal').modal('hide');
                switch(request.status){
                    case 422:
                        notify("<i class='fa fa-exclamation-triangle text-warning'></i> มีข้อผิดพลาดของข้อมูล โปรดตรวจสอบรูปแบบข้อมูลอีกครั้ง", "warning");
                    break;
                    case 424:
                        notify("<i class='fa fa-exclamation-triangle text-warning'></i> คุณสมบัติไม่ครบถ้วน กรุณาติดต่อ <เบอร์ห้องวิชาการ>", "warning");
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

<?php
/*
var schoolsList = new Bloodhound({
    datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.word); },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    limit: 4,
    prefetch: {
        url: "https://cdn1.namodev.com/TUEnt/schools.json",
        filter: function(schoolsArray) {
            return $.map(schoolsArray, function(school) {
                return {word: school};
            });
        }
    },
});

schoolsList.clearPrefetchCache();
schoolsList.initialize();

$('#school').typeahead(null, {
  name: 'schoolsList',
  displayKey: 'word',
  highlight: true,
  source: schoolsList.ttAdapter()
});

*/
 ?>
