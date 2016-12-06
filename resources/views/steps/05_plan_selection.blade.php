@extends('layouts.master')

@section('title', 'แผนการเรียนที่สมัคร')

@section('content')
<legend><i class="fa fa-institution"></i> แผนการเรียนที่สมัคร <i class="fa fa-spinner fa-spin text-muted pull-right" style="display:none;" id="loadingSpinner"></i></legend>
{{--
<div class="row">
    <div class="col-md-12" id="applicationTypeCol">
        <span class="help-block">ประเภทการสมัคร</span>
        <select id="application_type" name="application_type" class="form-control select select-primary select-block mbl" {{ Config::get("uiconfig.mode") == "province_quota" ? "disabled" : ""}}>
            @if(Config::get("uiconfig.mode") == "province_quota")
                <option value="2">นักเรียนในโครงการโควตาจังหวัด</option>
            @else
                <option value="0">นักเรียนปกติ</option>
                <option value="1">นักเรียนความสามารถพิเศษ (โควตา)</option>
            @endif
        </select>
    </div>
    <div class="col-md-7" style="display:none;" id="quotaTypeCol">
        <span class="help-block">ประเภทโควตา</span>
        <select id="quota_type" name="quota_type" class="form-control select select-primary select-block mbl">
            {{ App\Http\Controllers\Helper::printQuotaSelectBox() }}
        </select>
    </div>
</div>
--}}
<div class="row">
    <div class="col-xs-12">
        <span class="help-block">แผนการเรียนที่นักเรียนต้องการสมัคร</span>
        <select id="plan" name="plan" class="form-control select select-primary select-block mbl">
            <?php
                if(isset($appliantData['plan'])){
                    $currentPlanSelected = $applicantData['plan'];
                }else{
                    $currentPlanSelected = 5; // (The power of) Science by default!
                }
                if(Config::get('uiconfig.mode') == 'province_quota'){
                    $plansAvailable = [
                        1 => "ภาษา-ฝรั่งเศส",
                        2 => "ภาษา-เยอรมัน",
                        3 => "ภาษา-ญี่ปุ่น",
                        4 => "ภาษา-คณิต",
                        5 => "วิทย์-คณิต",
                    ];
                }else{
                    $plansAvailable = [
                        1 => "ภาษา-ฝรั่งเศส",
                        2 => "ภาษา-เยอรมัน",
                        3 => "ภาษา-ญี่ปุ่น",
                        4 => "ภาษา-คณิต",
                        5 => "วิทย์-คณิต",
                        7 => "ภาษา-สเปน",
                        8 => "ภาษา-จีน",
                        9 => "ภาษา-เกาหลี",
                    ];
                }
                foreach($plansAvailable as $planID => $planName){
                    if($planID == $currentPlanSelected){
                        echo("<option value=\"$planID\" selected>$planName</option>");
                    }else{
                        echo("<option value=\"$planID\">$planName</option>");
                    }
                }
            ?>
        </select>
    </div>
</div>
<?php /*
<div class="row" id="scienceMajorSelectionGroup" style="display:none;">
    <div class="col-xs-12">
        <div class="well">
            <div class="row">
                <div class="col-xs-12">
                    <h6 style="font-size:1.1em;"><b>วิทย์-คณิต:</b> เลือกลำดับกลุ่มสาระการเรียนรู้ที่เน้น <button class="btn btn-warning pull-right" id="clearMajorSelection"> <i class="fa fa-undo"></i> เลือกใหม่ </button></h6>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <span class="help-block">อันดับที่ 1</span>
                    <select id="sm_1" name="sm_1" class="form-control select select-primary select-block mbl scienceMajorSelector">
                        <?php
                            $options = [
                                "-1" => "--- เลือกกลุ่มสาระ ---",
                                "1" => "คอมพิวเตอร์",
                                "2" => "การบริหารจัดการ",
                                "3" => "คุณภาพชีวิต",
                                "4" => "คณิตศาสตร์ประยุกต์",
                                "5" => "ภาษาจีน",
                                "6" => "ภาษาญี่ปุ่น",
                                "7" => "ภาษาเยอรมัน",
                                "8" => "ภาษาฝรั่งเศส",
                            ];

                            if(isset($applicantData["majors"]["0"])){
                                foreach($options as $key => $option){
                                    if($applicantData["majors"]["0"] == $key){
                                        echo("<option value=\"$key\" selected>$option</option>");
                                    }else{
                                        echo("<option value=\"$key\">$option</option>");
                                    }
                                }
                            }else{
                                foreach($options as $key => $option){
                                    echo("<option value=\"$key\">$option</option>");
                                }
                            }

                        ?>
                    </select>
                </div>
                <div class="col-xs-12">
                    <span class="help-block">อันดับที่ 2</span>
                    <select id="sm_2" name="sm_2" class="form-control select select-primary select-block mbl scienceMajorSelector" disabled>
                        <?php
                            if(isset($applicantData["majors"]["1"])){
                                echo("<option value=\"" . $applicantData["majors"]["1"] . "\" selected>" . App\Http\Controllers\Helper::whatScienceMajor($applicantData["majors"]["1"]) . "</option>");
                            }
                            echo("<option value=\"-1\">--- เลือกกลุ่มสาระ ---</option>");
                        ?>
                    </select>
                </div>
                <div class="col-xs-12">
                    <span class="help-block">อันดับที่ 3</span>
                    <select id="sm_3" name="sm_3" class="form-control select select-primary select-block mbl scienceMajorSelector" disabled>
                        <?php
                            if(isset($applicantData["majors"]["2"])){
                                echo("<option value=\"" . $applicantData["majors"]["2"] . "\" selected>" . App\Http\Controllers\Helper::whatScienceMajor($applicantData["majors"]["2"]) . "</option>");
                            }
                            echo("<option value=\"-1\">--- เลือกกลุ่มสาระ ---</option>");
                        ?>
                    </select>
                </div>
                <div class="col-xs-12">
                    <span class="help-block">อันดับที่ 4</span>
                    <select id="sm_4" name="sm_4" class="form-control select select-primary select-block mbl scienceMajorSelector" disabled>
                        <?php
                            if(isset($applicantData["majors"]["3"])){
                                echo("<option value=\"" . $applicantData["majors"]["3"] . "\" selected>" . App\Http\Controllers\Helper::whatScienceMajor($applicantData["majors"]["3"]) . "</option>");
                            }
                            echo("<option value=\"-1\">--- เลือกกลุ่มสาระ ---</option>");
                        ?>
                    </select>
                </div>
                <div class="col-xs-12">
                    <span class="help-block">อันดับที่ 5</span>
                    <select id="sm_5" name="sm_5" class="form-control select select-primary select-block mbl scienceMajorSelector" disabled>
                        <?php
                            if(isset($applicantData["majors"]["4"])){
                                echo("<option value=\"" . $applicantData["majors"]["4"] . "\" selected>" . App\Http\Controllers\Helper::whatScienceMajor($applicantData["majors"]["4"]) . "</option>");
                            }
                            echo("<option value=\"-1\">--- เลือกกลุ่มสาระ ---</option>");
                        ?>
                    </select>
                </div>
                <div class="col-xs-12">
                    <span class="help-block">อันดับที่ 6</span>
                    <select id="sm_6" name="sm_6" class="form-control select select-primary select-block mbl scienceMajorSelector" disabled>
                        <?php
                            if(isset($applicantData["majors"]["5"])){
                                echo("<option value=\"" . $applicantData["majors"]["5"] . "\" selected>" . App\Http\Controllers\Helper::whatScienceMajor($applicantData["majors"]["5"]) . "</option>");
                            }
                            echo("<option value=\"-1\">--- เลือกกลุ่มสาระ ---</option>");
                        ?>
                    </select>
                </div>
                <div class="col-xs-12">
                    <span class="help-block">อันดับที่ 7</span>
                    <select id="sm_7" name="sm_7" class="form-control select select-primary select-block mbl scienceMajorSelector" disabled>
                        <?php
                            if(isset($applicantData["majors"]["6"])){
                                echo("<option value=\"" . $applicantData["majors"]["6"] . "\" selected>" . App\Http\Controllers\Helper::whatScienceMajor($applicantData["majors"]["6"]) . "</option>");
                            }
                            echo("<option value=\"-1\">--- เลือกกลุ่มสาระ ---</option>");
                        ?>
                    </select>
                </div>
                <div class="col-xs-12">
                    <span class="help-block">อันดับที่ 8</span>
                    <select id="sm_8" name="sm_8" class="form-control select select-primary select-block mbl scienceMajorSelector" disabled>
                        <?php
                            if(isset($applicantData["majors"]["7"])){
                                echo("<option value=\"" . $applicantData["majors"]["7"] . "\" selected>" . App\Http\Controllers\Helper::whatScienceMajor($applicantData["majors"]["7"]) . "</option>");
                            }
                            echo("<option value=\"-1\">--- เลือกกลุ่มสาระ ---</option>");
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
*/?>
<?php //TODO Turn this mockup to a real thing ?>
<div class="row">
    <div class="col-xs-12">
        <div class="well">
            <div class="row">
                <div class="col-xs-12">
                    กรอกเกรดเฉลี่ย <b>5 ภาคเรียน</b> ของแต่ละรายวิชาลงในช่องด้านล่าง
                </div>
            </div>
            <div class="row" id="gradegroup_sm">
                <div class="col-sm-3" id="sm_basicmathGroup">
                    <span class="help-block">คณิตศาสตร์พื้นฐาน</span>
                    <input id="sm_basicmath" name="" type="text" placeholder="ในรูปแบบ 4.00" class="form-control" value="{{ isset($applicantData['quota_grade']['math_basic']) ? $applicantData['quota_grade']['math_basic'] : ''}}"/>
                </div>
                <div class="col-sm-3" id="sm_basicsciGroup">
                    <span class="help-block">วิทยาศาสตร์พื้นฐาน</span>
                    <input id="sm_basicsci" name="" type="text" placeholder="ในรูปแบบ 4.00" class="form-control" value="{{ isset($applicantData['quota_grade']['science_basic']) ? $applicantData['quota_grade']['science_basic'] : ''}}"/>
                </div>
                <div class="col-sm-3" id="sm_advancedmathGroup">
                    <span class="help-block">คณิตศาสตร์เพิ่มเติม</span>
                    <input id="sm_advancedmath" name="" type="text" placeholder="ในรูปแบบ 4.00" class="form-control" value="{{ isset($applicantData['quota_grade']['math_advanced']) ? $applicantData['quota_grade']['math_advanced'] : ''}}"/>
                </div>
                <div class="col-sm-3" id="sm_advancedscienceGroup">
                    <span class="help-block">วิทยาศาสตร์เพิ่มเติม</span>
                    <input id="sm_advancedscience" name="" type="text" placeholder="ในรูปแบบ 4.00" class="form-control" value="{{ isset($applicantData['quota_grade']['science_advanced']) ? $applicantData['quota_grade']['science_advanced'] : ''}}"/>
                </div>
            </div>

            <div class="row" id="gradegroup_am" style="display:none;">
                <div class="col-sm-2 col-sm-offset-1" id="am_thaiGroup">
                    <span class="help-block">ภาษาไทย<br />พื้นฐาน</span>
                    <input id="am_thai" name="" type="text" placeholder="รูปแบบ 4.00" class="form-control" value="{{ isset($applicantData['quota_grade']['thai_basic']) ? $applicantData['quota_grade']['thai_basic'] : ''}}"/>
                </div>
                <div class="col-sm-2" id="am_basicmathGroup">
                    <span class="help-block">คณิตศาสตร์<br />พื้นฐาน</span>
                    <input id="am_basicmath" name="" type="text" placeholder="รูปแบบ 4.00" class="form-control" value="{{ isset($applicantData['quota_grade']['math_basic']) ? $applicantData['quota_grade']['math_basic'] : ''}}"/>
                </div>
                <div class="col-sm-2" id="am_advancedmathGroup">
                    <span class="help-block">คณิตศาสตร์<br />เพิ่มเติม</span>
                    <input id="am_advancedmath" name="" type="text" placeholder="รูปแบบ 4.00" class="form-control" value="{{ isset($applicantData['quota_grade']['math_advanced']) ? $applicantData['quota_grade']['math_advanced'] : ''}}"/>
                </div>
                <div class="col-sm-2" id="am_basicengGroup">
                    <span class="help-block">ภาษาอังกฤษ<br />พื้นฐาน</span>
                    <input id="am_basiceng" name="" type="text" placeholder="รูปแบบ 4.00" class="form-control" value="{{ isset($applicantData['quota_grade']['english_basic']) ? $applicantData['quota_grade']['english_basic'] : ''}}"/>
                </div>
                <div class="col-sm-2" id="am_advancedengGroup">
                    <span class="help-block">ภาษาอังกฤษ<br />เพิ่มเติม</span>
                    <input id="am_advancedeng" name="" type="text" placeholder="รูปแบบ 4.00" class="form-control" value="{{ isset($applicantData['quota_grade']['english_advanced']) ? $applicantData['quota_grade']['english_advanced'] : ''}}"/>
                </div>
            </div>

            <div class="row" id="gradegroup_ar" style="display:none;">
                <div class="col-sm-3" id="ar_basicthaiGroup">
                    <span class="help-block">ภาษาไทยพื้นฐาน</span>
                    <input id="ar_basicthai" name="" type="text" placeholder="ในรูปแบบ 4.00" class="form-control" value="{{ isset($applicantData['quota_grade']['thai_basic']) ? $applicantData['quota_grade']['thai_basic'] : ''}}"/>
                </div>
                <div class="col-sm-3" id="ar_basicengGroup">
                    <span class="help-block">ภาษาอังกฤษพื้นฐาน</span>
                    <input id="ar_basiceng" name="" type="text" placeholder="ในรูปแบบ 4.00" class="form-control" value="{{ isset($applicantData['quota_grade']['english_basic']) ? $applicantData['quota_grade']['english_basic'] : ''}}"/>
                </div>
                <div class="col-sm-3" id="ar_advancedengGroup">
                    <span class="help-block">ภาษาอังกฤษเพิ่มเติม</span>
                    <input id="ar_advancedeng" name="" type="text" placeholder="ในรูปแบบ 4.00" class="form-control" value="{{ isset($applicantData['quota_grade']['english_advanced']) ? $applicantData['quota_grade']['english_advanced'] : ''}}"/>
                </div>
                <div class="col-sm-3" id="ar_basicsocGroup">
                    <span class="help-block">สังคมศึกษาพื้นฐาน</span>
                    <input id="ar_basicsoc" name="" type="text" placeholder="ในรูปแบบ 4.00" class="form-control" value="{{ isset($applicantData['quota_grade']['social_basic']) ? $applicantData['quota_grade']['social_basic'] : ''}}"/>
                </div>
            </div>

        </div>
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
<script>

var lang_chinese_in_list = 1;
var scienceMajors = {
    1: "คอมพิวเตอร์",
    2: "การบริหารจัดการ",
    3: "คุณภาพชีวิต",
    4: "คณิตศาสตร์ประยุกต์",
    5: "ภาษาจีน",
    6: "ภาษาญี่ปุ่น",
    7: "ภาษาเยอรมัน",
    8: "ภาษาฝรั่งเศส"
};
var scienceMajorsSelected = [];
var activeMajorSelectBox = 1;
var majorSelectionComplete = 0;
var currentApplicationPath = "sm";

$(function(){
    $("#application_type").change();
    $("#quota_type").change();

    @if(isset($applicantData['plan']))
        $("#plan").val("{{ $applicantData['plan'] }}").trigger("change");
    @else
        $("#plan").val("5").trigger("change");
    @endif

    $("#plan").change();

});
$("#application_type").change(function(){

    /* Ability quota? */
    if($("#application_type").val() == 1){
        $("#quotaTypeCol").fadeIn(200);
        $("#applicationTypeCol").removeClass("col-md-12").addClass("col-md-5");
    }else{
        $("#quotaTypeCol").fadeOut(200, function(){
            $("#applicationTypeCol").removeClass("col-md-5").addClass("col-md-12");
        });
    }

    /* District quota? */
    if($("#application_type").val() == 2){
        $("#plan option[value='8']").remove();
        lang_chinese_in_list = 0;
    }else{
        if(lang_chinese_in_list != 1){
            $("#plan").append("<option value=\"8\">ภาษา-จีน</option>");
            lang_chinese_in_list = 1;
        }
    }

    /* Re-sort the select box by option value */
    sortSelectBox();

});
$("select[id*=\"sm_\"]").change(function(){
    updateScienceMajorSelectionBoxes();
});
$("#plan").change(function(){
    switch(parseInt($("#plan").val())){
        case 5:
            $("#gradegroup_sm").fadeIn(200);
            $("#gradegroup_am").fadeOut(200);
            $("#gradegroup_ar").fadeOut(200);
            currentApplicationPath = "sm";
        break;
        case 4:
            $("#gradegroup_sm").fadeOut(200);
            $("#gradegroup_am").fadeIn(200);
            $("#gradegroup_ar").fadeOut(200);
            currentApplicationPath = "am";
        break;
        default:
            $("#gradegroup_sm").fadeOut(200);
            $("#gradegroup_am").fadeOut(200);
            $("#gradegroup_ar").fadeIn(200);
            currentApplicationPath = "ar";
    }
});
function sortSelectBox(){
    var selectList = $('#plan option');
    selectList.sort(function(a,b){
        a = a.value;
        b = b.value;
        return a-b;
    });
    $('#plan').html(selectList);
}

$("#sendTheFormButton").click(function(){

    // Tell the user to wait:
    $("#plsWaitModal").modal("show");

    // Error checking variable
    var hasErrors = 0;

    // TODO: More front-end checks here?
    // TODO: Grade input box validation depending on application path

    // Validate & group grade data for each application path:
    switch(currentApplicationPath){
        case "sm":
            hasErrors += isFieldBlank("sm_basicmath");
            hasErrors += isFieldBlank("sm_basicsci");
            hasErrors += isFieldBlank("sm_advancedmath");
            hasErrors += isFieldBlank("sm_advancedscience");
            var gradeData = {
                "math_basic" : $("#sm_basicmath").val(),
                "math_advanced": $("#sm_advancedmath").val(),
                "science_basic" : $("#sm_basicsci").val(),
                "science_advanced": $("#sm_advancedscience").val()
            }
        break;
        case "am":
            hasErrors += isFieldBlank("am_thai");
            hasErrors += isFieldBlank("am_basicmath");
            hasErrors += isFieldBlank("am_advancedmath");
            hasErrors += isFieldBlank("am_basiceng");
            hasErrors += isFieldBlank("am_advancedeng");
            var gradeData = {
                "math_basic" : $("#am_basicmath").val(),
                "math_advanced": $("#am_advancedmath").val(),
                "english_basic" : $("#am_basiceng").val(),
                "english_advanced": $("#am_advancedeng").val(),
                "thai_basic" :  $("#am_thai").val()
            }
        break;
        case "ar":
            hasErrors += isFieldBlank("ar_basicthai");
            hasErrors += isFieldBlank("ar_basiceng");
            hasErrors += isFieldBlank("ar_advancedeng");
            hasErrors += isFieldBlank("ar_basicsoc");
            var gradeData = {
                "english_basic" : $("#ar_basiceng").val(),
                "english_advanced": $("#ar_advancedeng").val(),
                "thai_basic" :  $("#ar_basicthai").val(),
                "social_basic" :  $("#ar_basicsoc").val()
            }
        break;
        default:
            // Shouldn't happen. Maybe throw an error here?
            hasErrors++;
    }

    console.log(gradeData);

    // Build the data-to-send array:
    var dataToSend = {
        _token: csrfToken,
        application_type: $("#application_type").val(),
        quota_type: $("#quota_type").val(),
        plan: $("#plan").val(),
        grade: gradeData
    };

    // Any errors?
    if(hasErrors == 0){
        // Nope.
        $.ajax({
            url: '/api/v1/applicant/plan_selection',
            data: dataToSend,
            error: function (request, status, error) {
                $("#plsWaitModal").modal("hide");
                switch(request.status){
                    case 422:
                        notify("<i class='fa fa-exclamation-triangle text-warning'></i> มีข้อผิดพลาดของข้อมูล โปรดตรวจสอบรูปแบบข้อมูลอีกครั้ง", "warning");
                    break;
                    case 424:
                        notify("<i class='fa fa-exclamation-triangle text-danger'></i> ขาดคุณสมบัติ กรุณาติดต่อ 02-252-7001 ต่อ 103 (กลุ่มบริหารวิชาการ)", "danger");
                    break;
                    default:
                        console.log("(" + request.status + ") Exception:" + request.responseText);
                        notify("<i class='fa fa-exclamation-triangle text-warning'></i> เกิดข้อผิดพลาดในการส่งข้อมูล กรุณาลองใหม่อีกครั้ง", "danger");
                }
            },
            dataType: 'json',
            success: function(data) {

                // Tell the user that everything went well
                $("#plsWaitModal").modal("hide");
                notify("<i class='fa fa-check'></i> บันทึกข้อมูลเรียบร้อย", "success");

                setTimeout(function(){
                     location.reload();
                }, 1500);

            },
            type: 'POST'
        });
    }

});

</script>
@endsection

<?php
/*


function updateScienceMajorSelectionBoxes(){

    // Only if the changed value is not -1, a.k.a. "Please select a major"
    if(parseInt($("#sm_" + activeMajorSelectBox).val()) != -1){

        // Read value of current box, add that in our "selected" array:
        scienceMajorsSelected.push($("#sm_" + activeMajorSelectBox).val());

        // Next selectbox id:
        var nextSelectBox = parseInt(activeMajorSelectBox) + 1;

        // Don't replace loaded stuff (continue replacing only if the value of the next select is -1):
        if(parseInt($("#sm_" + nextSelectBox).val()) === -1){

            // Clear the next selectbox and append with placeholder:
            $("#sm_" + nextSelectBox).empty();
            $("#sm_" + nextSelectBox).append("<option value=\"-1\">--- เลือกกลุ่มสาระ ---</option>");

            // Populate the next major select box, minus the 'already selected' options:
            $.each(scienceMajors, function(index, value){
                if($.inArray(index, scienceMajorsSelected) == -1){
                    // This option isn't selected yet. Pushable!
                    $("#sm_" + nextSelectBox).append("<option value=\"" + index + "\">" + value + "</option>");
                }
            });
        }

        switch(activeMajorSelectBox){
            case 1:
                enableScienceMajorSelectBox(2);
            break;
            case 2:
                enableScienceMajorSelectBox(3);
            break;
            case 3:
                enableScienceMajorSelectBox(4);
            break;
            case 4:
                enableScienceMajorSelectBox(5);
            break;
            case 5:
                enableScienceMajorSelectBox(6);
            break;
            case 6:
                enableScienceMajorSelectBox(7);
            break;
            case 7:
                enableScienceMajorSelectBox(8);
            break;
            case 8:
                $("#sm_8").prop("disabled", true);
                majorSelectionComplete = 1;
            break;
        }

        // Increment active pointer, only if we're not at the final step already:
        if(activeMajorSelectBox < 8){
            activeMajorSelectBox++;
        }
    }

}

$("#clearMajorSelection").click(function(){
    // Are you sure?
    bootbox.confirm({
        message: "<b>ยืนยันการเลือกกลุ่มสาระการเรียนรู้ที่เน้นใหม่</b><br />ตัวเลือกปัจจุบันของนักเรียนจะถูกล้างค่าทั้งหมด โปรดยืนยันการดำเนินการต่อ",
        buttons: {
            cancel: {
                label: "<i class=\"fa fa-times\"></i> ยกเลิก"
            },
            confirm: {
                label: "<i class=\"fa fa-check\"></i> ยืนยัน"
            }
        },
        callback: function (result) {
            if(result === true){
                // Reset selections:
                $("[id^=sm_]").val("-1").trigger("change.select2");

                // Reset completion status:
                majorSelectionComplete = 0;

                // Clear the old 'selected' array & reset index
                scienceMajorsSelected.length = 0;
                activeMajorSelectBox = 1;

                // Re-enable the first box
                enableScienceMajorSelectBox(1);
            }
        }
    });

});

function enableScienceMajorSelectBox(id){
    $("[id^=sm_]").prop("disabled", true);
    $("#sm_" + id).prop("disabled", false);
    return true;
}

*/
 ?>
