@extends('layouts.master')

@section('title', 'ข้อมูลผู้ปกครอง')

@section('content')
<legend><i class="fa fa-user-plus"></i> ข้อมูลบิดา มารดา และผู้ปกครอง <i class="fa fa-spinner fa-spin text-muted pull-right" style="display:none;" id="loadingSpinner"></i></legend>
<div class="row">
    <div class="col-xs-12">
        <p class="badge" style="font-size:.9em;font-weight:normal;">&nbsp;&nbsp; บิดา &nbsp;&nbsp;</p>
        <div class="row">
            <div class="col-md-3 col-xs-4" id="father_titleGroup">
                <span class="help-block">คำนำหน้าชื่อ</span>
                <input id="father_title" name="father_title" type="text" placeholder="คำนำหน้าชื่อ" class="form-control" value="{{ isset($applicantData['father']['title']) ? $applicantData['father']['title'] : '' }}"/>
            </div>
            <div class="col-md-4 col-xs-8" id="father_fnameGroup">
                <span class="help-block">ชื่อ</span>
                <input id="father_fname" name="father_fname" type="text" placeholder="ชื่อ" class="form-control" value="{{ isset($applicantData['father']['fname']) ? $applicantData['father']['fname'] : '' }}" />
            </div>
            <div class="col-md-5 col-xs-12" id="father_lnameGroup">
                <span class="help-block">นามสกุล</span>
                <input id="father_lname" name="father_lname" type="text" placeholder="นามสกุล" class="form-control" value="{{ isset($applicantData['father']['lname']) ? $applicantData['father']['lname'] : '' }}" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-xs-12" id="father_phoneGroup">
                <span class="help-block">หมายเลขโทรศัพท์</span>
                <input id="father_phone" name="father_phone" type="text" placeholder="หากไม่มีให้ใส่ขีด (-)" class="form-control" value="{{ isset($applicantData['father']['phone']) ? $applicantData['father']['phone'] : '' }}" />
            </div>
            <div class="col-md-4 col-xs-12" id="father_occupationGroup">
                <span class="help-block">อาชีพ</span>
                <input id="father_occupation" name="father_occupation" type="text" placeholder="อาชีพ" class="form-control" value="{{ isset($applicantData['father']['occupation']) ? $applicantData['father']['occupation'] : '' }}" />
            </div>
            <div class="col-md-5 col-xs-12" id="father_deadGroup">
                <span class="help-block">&nbsp;</span>
                <label class="checkbox"><input type="checkbox" id="father_dead" name="father_dead" {{ isset($applicantData['father']['dead']) && $applicantData['father']['dead'] == "1" ? "checked" : "" }}> บิดาเสียชีวิต</label>
            </div>
        </div>
    </div>
</div>
<br />
<div class="row">
    <div class="col-xs-12">
        <p class="badge" style="font-size:.9em;font-weight:normal;">&nbsp;&nbsp; มารดา &nbsp;&nbsp;</p>
        <div class="row">
            <div class="col-md-3 col-xs-4" id="mother_titleGroup">
                <span class="help-block">คำนำหน้าชื่อ</span>
                <input id="mother_title" name="mother_title" type="text" placeholder="คำนำหน้าชื่อ" class="form-control" value="{{ isset($applicantData['mother']['title']) ? $applicantData['mother']['title'] : '' }}" />
            </div>
            <div class="col-md-4 col-xs-8" id="mother_fnameGroup">
                <span class="help-block">ชื่อ</span>
                <input id="mother_fname" name="mother_fname" type="text" placeholder="ชื่อ" class="form-control" value="{{ isset($applicantData['mother']['fname']) ? $applicantData['mother']['fname'] : '' }}" />
            </div>
            <div class="col-md-5 col-xs-12" id="mother_lnameGroup">
                <span class="help-block">นามสกุล</span>
                <input id="mother_lname" name="mother_lname" type="text" placeholder="นามสกุล" class="form-control" value="{{ isset($applicantData['mother']['lname']) ? $applicantData['mother']['lname'] : '' }}" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-xs-12" id="mother_phoneGroup">
                <span class="help-block">หมายเลขโทรศัพท์</span>
                <input id="mother_phone" name="mother_phone" type="text" placeholder="หากไม่มีให้ใส่ขีด (-)" class="form-control" value="{{ isset($applicantData['mother']['phone']) ? $applicantData['mother']['phone'] : '' }}" />
            </div>
            <div class="col-md-4 col-xs-12" id="mother_occupationGroup">
                <span class="help-block">อาชีพ</span>
                <input id="mother_occupation" name="mother_occupation" type="text" placeholder="อาชีพ" class="form-control" value="{{ isset($applicantData['mother']['occupation']) ? $applicantData['mother']['occupation'] : '' }}" />
            </div>
            <div class="col-md-5 col-xs-12" id="mother_deadGroup">
                <span class="help-block">&nbsp;</span>
                <label class="checkbox"><input type="checkbox" id="mother_dead" name="mother_dead" {{ isset($applicantData['mother']['dead']) && $applicantData['mother']['dead'] == "1" ? "checked" : "" }}> มารดาเสียชีวิต</label>
            </div>
        </div>
    </div>
</div>
<br />
<div class="row">
    <div class="col-xs-12">
        <span class="help-block">ผู้ปกครองของนักเรียน</span>
        <select id="staying_with" name="staying_with" class="form-control select select-primary select-block mbl">
            <?php
                $options = [
                    "1" => "บิดา",
                    "2" => "มารดา",
                    "3" => "อื่นๆ"
                ];
                if(isset($applicantData['staying_with_parent'])){
                    foreach($options as $key => $option){
                        if($key == $applicantData['staying_with_parent']){
                            echo("<option value=\"$key\" selected>$option</option>");
                        }else{
                            echo("<option value=\"$key\">$option</option>");
                        }
                    }
                }else{
                    echo("
                    <option value=\"1\">บิดา</option>
                    <option value=\"2\">มารดา</option>
                    <option value=\"3\">อื่นๆ</option>
                    ");
                }
            ?>
        </select>
    </div>
</div>
<div class="row" id="guardianInfoGroup" style="display:none;">
    <div class="col-xs-12">
        <p class="badge" style="font-size:.9em;font-weight:normal;">&nbsp;&nbsp; ผู้ปกครอง &nbsp;&nbsp;</p>
        <div class="row">
            <div class="col-md-3 col-xs-4" id="guardian_titleGroup">
                <span class="help-block">คำนำหน้าชื่อ</span>
                <input id="guardian_title" name="guardian_title" type="text" placeholder="คำนำหน้าชื่อ" class="form-control" value="{{ isset($applicantData['guardian']['title']) ? $applicantData['guardian']['title'] : '' }}" />
            </div>
            <div class="col-md-4 col-xs-8" id="guardian_fnameGroup">
                <span class="help-block">ชื่อ</span>
                <input id="guardian_fname" name="guardian_fname" type="text" placeholder="ชื่อ" class="form-control" value="{{ isset($applicantData['guardian']['fname']) ? $applicantData['guardian']['fname'] : '' }}" />
            </div>
            <div class="col-md-5 col-xs-12" id="guardian_lnameGroup">
                <span class="help-block">นามสกุล</span>
                <input id="guardian_lname" name="guardian_lname" type="text" placeholder="นามสกุล" class="form-control" value="{{ isset($applicantData['guardian']['lname']) ? $applicantData['guardian']['lname'] : '' }}" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-xs-12" id="guardian_phoneGroup">
                <span class="help-block">หมายเลขโทรศัพท์</span>
                <input id="guardian_phone" name="guardian_phone" type="text" placeholder="หากไม่มีให้ใส่ขีด (-)" class="form-control" value="{{ isset($applicantData['guardian']['phone']) ? $applicantData['guardian']['phone'] : '' }}" />
            </div>
            <div class="col-md-4 col-xs-12" id="guardian_occupationGroup">
                <span class="help-block">อาชีพ</span>
                <input id="guardian_occupation" name="guardian_occupation" type="text" placeholder="อาชีพ" class="form-control" value="{{ isset($applicantData['guardian']['occupation']) ? $applicantData['guardian']['occupation'] : '' }}" />
            </div>
            <div class="col-md-5 col-xs-12" id="guardian_relationGroup">
                <span class="help-block">ความสัมพันธ์กับนักเรียน</span>
                <input id="guardian_relation" name="guardian_relation" type="text" placeholder="ความสัมพันธ์กับนักเรียน" class="form-control" value="{{ isset($applicantData['guardian']['relation']) ? $applicantData['guardian']['relation'] : '' }}" />
            </div>
        </div>
    </div>
    <div class="col-xs-12">
        <br />
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
var fatherOption = 1;
var motherOption = 1;
var hasGuardian = 0;

$(function(){
    $("#father_dead").change();
    $("#mother_dead").change();
    $("#staying_with").change();
});
$("#staying_with").change(function(){
    if($("#staying_with").val() == 1 || $("#staying_with").val() == 2){
        $("#guardianInfoGroup").fadeOut(200);
        hasGuardian = 0;
    }else{
        $("#guardianInfoGroup").fadeIn(200);
        hasGuardian = 1;
    }
});
$("#father_dead").change(function(){
    if($("#father_dead").is(":checked")){
        $("#father_occupation").prop("disabled", true);
        $("#father_phone").prop("disabled", true);
        $("#father_occupation").val('');
        $("#father_phone").val('');
        $("#staying_with option[value='1']").remove();
        fatherOption = 0;
    }else{
        $("#father_occupation").prop("disabled", false);
        $("#father_phone").prop("disabled", false);
        if(fatherOption == 0){
            $("#staying_with").append("<option value=\"1\">บิดา</option>");
            fatherOption = 1;
            sortSelect("staying_with");
        }
    }
    $("#staying_with").select2("destroy").select2();
    checkDeadParents();
});
$("#mother_dead").change(function(){
    if($("#mother_dead").is(":checked")){
        $("#mother_occupation").prop("disabled", true);
        $("#mother_phone").prop("disabled", true);
        $("#mother_occupation").val('');
        $("#mother_phone").val('');
        $("#staying_with option[value='2']").remove();
        motherOption = 0;
    }else{
        $("#mother_occupation").prop("disabled", false);
        $("#mother_phone").prop("disabled", false);
        if(motherOption == 0){
            $("#staying_with").append("<option value=\"2\">มารดา</option>");
            motherOption = 1;
            sortSelect("staying_with");
        }
    }
    $("#staying_with").select2("destroy").select2();
    checkDeadParents();
});
$("#sendTheFormButton").click(function(){
    /* Form submission */
    $('#plsWaitModal').modal('show');
    var hasErrors = 0; // Error checking variable

    // Check for dead status?
    var fatherIsDead = 0;
    var motherIsDead = 0;
    if($("#father_dead").is(":checked")){fatherIsDead = 1;};
    if($("#mother_dead").is(":checked")){motherIsDead = 1;};

    // Check father information inputs
    hasErrors += isFieldBlank("father_title");
    hasErrors += isFieldBlank("father_fname");
    hasErrors += isFieldBlank("father_lname");
    if(fatherIsDead != 1){
        hasErrors += isFieldBlank("father_phone");
        hasErrors += isFieldBlank("father_occupation");
    }

    // Check mother information inputs
    hasErrors += isFieldBlank("mother_title");
    hasErrors += isFieldBlank("mother_fname");
    hasErrors += isFieldBlank("mother_lname");
    if(motherIsDead != 1){
        hasErrors += isFieldBlank("mother_phone");
        hasErrors += isFieldBlank("mother_occupation");
    }

    // Check guardian information inputs if applicable:
    if(hasGuardian == 1){
        hasErrors += isFieldBlank("guardian_title");
        hasErrors += isFieldBlank("guardian_fname");
        hasErrors += isFieldBlank("guardian_lname");
        hasErrors += isFieldBlank("guardian_phone");
        hasErrors += isFieldBlank("guardian_occupation");
        hasErrors += isFieldBlank("guardian_relation");
    }

    @if(Config::get('app.debug') === true)
        console.log("[DBG/LOG] Total errors: " + hasErrors);
    @endif

    if(parseInt(hasErrors) == 0){
        // Green across the board, and ready for action!
        $.ajax({
            url: '/api/v1/applicant/parent_info',
            data: {
                _token: csrfToken,
                father_title: $("#father_title").val(),
                father_fname: $("#father_fname").val(),
                father_lname: $("#father_lname").val(),
                father_phone: $("#father_phone").val(),
                father_occupation: $("#father_occupation").val(),
                father_dead: fatherIsDead,
                mother_title: $("#mother_title").val(),
                mother_fname: $("#mother_fname").val(),
                mother_lname: $("#mother_lname").val(),
                mother_phone: $("#mother_phone").val(),
                mother_occupation: $("#mother_occupation").val(),
                mother_dead: motherIsDead,
                has_guardian: hasGuardian,
                staying_with: $("#staying_with").val(),
                guardian_title: $("#guardian_title").val(),
                guardian_fname: $("#guardian_fname").val(),
                guardian_lname: $("#guardian_lname").val(),
                guardian_phone: $("#guardian_phone").val(),
                guardian_occupation: $("#guardian_occupation").val(),
                guardian_relation: $("#guardian_relation").val()
            },
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
        // NOPE.
        $('#plsWaitModal').modal('hide');
        notify("<i class='fa fa-exclamation-triangle text-warning'></i> มีข้อผิดพลาดของข้อมูล โปรดตรวจสอบรูปแบบข้อมูลอีกครั้ง", "warning");
    }

});
function checkDeadParents(){
    if($("#father_dead").is(":checked") && $("#mother_dead").is(":checked")){
        $("#staying_with").val("3").trigger("change");
        $("#staying_with").prop("disabled", true);
    }else{
        $("#staying_with").prop("disabled", false);
    }
}
function sortSelect(box){
    var selectList = $('#' + box + ' option');
    selectList.sort(function(a,b){
        a = a.value;
        b = b.value;
        return a-b;
    });
    $('#' + box).html(selectList);
    return true;
}
</script>
@endsection
