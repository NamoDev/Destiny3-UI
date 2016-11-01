@extends('layouts.master')

@section('title', 'เลือกแผนการเรียน')

@section('content')
<legend><i class="fa fa-institution"></i> เลือกแผนการเรียน <i class="fa fa-spinner fa-spin text-muted pull-right" style="display:none;" id="loadingSpinner"></i></legend>
<div class="row">
    <div class="col-md-12" id="applicationTypeCol">
        <span class="help-block">ประเภทการสมัคร</span>
        <select id="application_type" name="application_type" class="form-control select select-primary select-block mbl">
            <option value="0">นักเรียนปกติ</option>
            <option value="1">นักเรียนความสามารถพิเศษ (โควตา)</option>
            <option value="2">นักเรียนในโครงการโควตาจังหวัด สพม.</option>
        </select>
    </div>
    <div class="col-md-7" style="display:none;" id="quotaTypeCol">
        <span class="help-block">ประเภทโควตา</span>
        <select id="quota_type" name="quota_type" class="form-control select select-primary select-block mbl">
            {{ App\Http\Controllers\Helper::printQuotaSelectBox() }}
        </select>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <span class="help-block">แผนการเรียนที่นักเรียนต้องการสมัคร</span>
        <select id="plan" name="plan" class="form-control select select-primary select-block mbl">
            <?php
                if(isset($appliantData['plan_id'])){
                    $currentPlanSelected = $applicantData['plan_id'];
                }else{
                    $currentPlanSelected = 5; // (The power of) Science by default!
                }
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
                        <option value="-1">--- เลือกกลุ่มสาระ ---</option>
                        <option value="1">คอมพิวเตอร์</option>
                        <option value="2">การบริหารจัดการ</option>
                        <option value="3">คุณภาพชีวิต</option>
                        <option value="4">คณิตศาสตร์ประยุกต์</option>
                        <option value="5">ภาษาจีน</option>
                        <option value="6">ภาษาญี่ปุ่น</option>
                        <option value="7">ภาษาเยอรมัน</option>
                        <option value="8">ภาษาฝรั่งเศส</option>
                    </select>
                </div>
                <div class="col-xs-12">
                    <span class="help-block">อันดับที่ 2</span>
                    <select id="sm_2" name="sm_2" class="form-control select select-primary select-block mbl scienceMajorSelector" disabled>
                        <option value="-1">--- เลือกกลุ่มสาระ ---</option>
                    </select>
                </div>
                <div class="col-xs-12">
                    <span class="help-block">อันดับที่ 3</span>
                    <select id="sm_3" name="sm_3" class="form-control select select-primary select-block mbl scienceMajorSelector" disabled>
                        <option value="-1">--- เลือกกลุ่มสาระ ---</option>
                    </select>
                </div>
                <div class="col-xs-12">
                    <span class="help-block">อันดับที่ 4</span>
                    <select id="sm_4" name="sm_4" class="form-control select select-primary select-block mbl scienceMajorSelector" disabled>
                        <option value="-1">--- เลือกกลุ่มสาระ ---</option>
                    </select>
                </div>
                <div class="col-xs-12">
                    <span class="help-block">อันดับที่ 5</span>
                    <select id="sm_5" name="sm_5" class="form-control select select-primary select-block mbl scienceMajorSelector" disabled>
                        <option value="-1">--- เลือกกลุ่มสาระ ---</option>
                    </select>
                </div>
                <div class="col-xs-12">
                    <span class="help-block">อันดับที่ 6</span>
                    <select id="sm_6" name="sm_6" class="form-control select select-primary select-block mbl scienceMajorSelector" disabled>
                        <option value="-1">--- เลือกกลุ่มสาระ ---</option>
                    </select>
                </div>
                <div class="col-xs-12">
                    <span class="help-block">อันดับที่ 7</span>
                    <select id="sm_7" name="sm_7" class="form-control select select-primary select-block mbl scienceMajorSelector" disabled>
                        <option value="-1">--- เลือกกลุ่มสาระ ---</option>
                    </select>
                </div>
                <div class="col-xs-12">
                    <span class="help-block">อันดับที่ 8</span>
                    <select id="sm_8" name="sm_8" class="form-control select select-primary select-block mbl scienceMajorSelector" disabled>
                        <option value="-1">--- เลือกกลุ่มสาระ ---</option>
                    </select>
                </div>
            </div>
        </div>
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

$(function(){
    $("#application_type").change();
    $("#quota_type").change();

    @if(isset($applicantData['plan_id']))
        $("#plan").val("{{ $applicantData['plan_id'] }}").trigger("change");
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
$(".scienceMajorSelector").change(function(){
    updateScienceMajorSelectionBoxes();
});
$("#plan").change(function(){
    if($("#plan").val() == 5){
        // Science. Enable major selection:
        if($("#scienceMajorSelectionGroup").not(":visible")){
            $("#scienceMajorSelectionGroup").fadeIn(200);
        }
    }else{
        if($("#scienceMajorSelectionGroup").is(":visible")){
            $("#scienceMajorSelectionGroup").fadeOut(200);
        }
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

function updateScienceMajorSelectionBoxes(){

    // Read value of current box, add that in our "selected" array:
    scienceMajorsSelected.push($("#sm_" + activeMajorSelectBox).val());

    // Next selectbox id:
    var nextSelectBox = parseInt(activeMajorSelectBox) + 1;

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
        break;
    }

    // Increment active pointer, only if we're not at the final step already:
    if(activeMajorSelectBox < 8){
        activeMajorSelectBox++;
    }
}

</script>
@endsection
