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
                <input id="father_title" name="father_title" type="text" placeholder="คำนำหน้าชื่อ" class="form-control" />
            </div>
            <div class="col-md-4 col-xs-8" id="father_fnameGroup">
                <span class="help-block">ชื่อ</span>
                <input id="father_fname" name="father_fname" type="text" placeholder="ชื่อ" class="form-control" />
            </div>
            <div class="col-md-5 col-xs-12" id="father_lnameGroup">
                <span class="help-block">นามสกุล</span>
                <input id="father_lname" name="father_lname" type="text" placeholder="นามสกุล" class="form-control" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-xs-12" id="father_phoneGroup">
                <span class="help-block">หมายเลขโทรศัพท์</span>
                <input id="father_phone" name="father_phone" type="text" placeholder="หากไม่มีให้ใส่ขีด (-)" class="form-control" />
            </div>
            <div class="col-md-4 col-xs-12" id="father_occupationGroup">
                <span class="help-block">อาชีพ</span>
                <input id="father_occupation" name="father_occupation" type="text" placeholder="อาชีพ" class="form-control" />
            </div>
            <div class="col-md-5 col-xs-12" id="father_deadGroup">
                <span class="help-block">&nbsp;</span>
                <label class="checkbox"><input type="checkbox" id="father_dead" name="father_dead"> บิดาเสียชีวิต</label>
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
                <input id="mother_title" name="mother_title" type="text" placeholder="คำนำหน้าชื่อ" class="form-control" />
            </div>
            <div class="col-md-4 col-xs-8" id="mother_fnameGroup">
                <span class="help-block">ชื่อ</span>
                <input id="mother_fname" name="mother_fname" type="text" placeholder="ชื่อ" class="form-control" />
            </div>
            <div class="col-md-5 col-xs-12" id="mother_lnameGroup">
                <span class="help-block">นามสกุล</span>
                <input id="mother_lname" name="mother_lname" type="text" placeholder="นามสกุล" class="form-control" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-xs-12" id="mother_phoneGroup">
                <span class="help-block">หมายเลขโทรศัพท์</span>
                <input id="mother_phone" name="mother_phone" type="text" placeholder="หากไม่มีให้ใส่ขีด (-)" class="form-control" />
            </div>
            <div class="col-md-4 col-xs-12" id="mother_occupationGroup">
                <span class="help-block">อาชีพ</span>
                <input id="mother_occupation" name="mother_occupation" type="text" placeholder="อาชีพ" class="form-control" />
            </div>
            <div class="col-md-5 col-xs-12" id="mother_deadGroup">
                <span class="help-block">&nbsp;</span>
                <label class="checkbox"><input type="checkbox" id="mother_dead" name="mother_dead"> มารดาเสียชีวิต</label>
            </div>
        </div>
    </div>
</div>
<br />
<div class="row">
    <div class="col-xs-12">
        <span class="help-block">ผู้ปกครองของนักเรียน</span>
        <select id="stayingWith" name="stayingWith" class="form-control select select-primary select-block mbl">
            <option value="1">บิดา</option>
            <option value="2">มารดา</option>
            <option value="3">อื่นๆ</option>
        </select>
    </div>
</div>
<br />
<div class="row" id="guardianInfoGroup" style="display:none;">
    <div class="col-xs-12">
        <p class="badge" style="font-size:.9em;font-weight:normal;">&nbsp;&nbsp; ผู้ปกครอง &nbsp;&nbsp;</p>
        <div class="row">
            <div class="col-md-3 col-xs-4" id="guardian_titleGroup">
                <span class="help-block">คำนำหน้าชื่อ</span>
                <input id="guardian_title" name="guardian_title" type="text" placeholder="คำนำหน้าชื่อ" class="form-control" />
            </div>
            <div class="col-md-4 col-xs-8" id="guardian_fnameGroup">
                <span class="help-block">ชื่อ</span>
                <input id="guardian_fname" name="guardian_fname" type="text" placeholder="ชื่อ" class="form-control" />
            </div>
            <div class="col-md-5 col-xs-12" id="guardian_lnameGroup">
                <span class="help-block">นามสกุล</span>
                <input id="guardian_lname" name="guardian_lname" type="text" placeholder="นามสกุล" class="form-control" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-xs-12" id="guardian_phoneGroup">
                <span class="help-block">หมายเลขโทรศัพท์</span>
                <input id="guardian_phone" name="guardian_phone" type="text" placeholder="หากไม่มีให้ใส่ขีด (-)" class="form-control" />
            </div>
            <div class="col-md-4 col-xs-12" id="guardian_occupationGroup">
                <span class="help-block">อาชีพ</span>
                <input id="guardian_occupation" name="guardian_occupation" type="text" placeholder="อาชีพ" class="form-control" />
            </div>
            <div class="col-md-5 col-xs-12" id="guardian_relationGroup">
                <span class="help-block">ความสัมพันธ์กับนักเรียน</span>
                <input id="guardian_relation" name="guardian_relation" type="text" placeholder="ความสัมพันธ์กับนักเรียน" class="form-control" />
            </div>
        </div>
    </div>
    <div class="col-xs-12">
        <br />
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

@section('additional_scripts')
<script>
$(function(){
    $("#father_dead").change();
    $("#mother_dead").change();
    $("#stayingWith").change();

    $('#father_dead').on('change',function(){
        if($("#father_dead").is(":checked")){
            $("#father_occupation").prop("disabled", true);
            $("#father_phone").prop("disabled", true);
            $("#father_occupation").val('');
            $("#father_phone").val('');
        }else{
            $("#father_occupation").prop("disabled", false);
            $("#father_phone").prop("disabled", false);
        }
    });
    $('#mother_dead').on('change',function(){
        if($("#mother_dead").is(":checked")){
            $("#mother_occupation").prop("disabled", true);
            $("#mother_phone").prop("disabled", true);
            $("#mother_occupation").val('');
            $("#mother_phone").val('');
        }else{
            $("#mother_occupation").prop("disabled", false);
            $("#mother_phone").prop("disabled", false);
        }
    });
    $("#stayingWith").on('change',function(){
        if($("#stayingWith").val() == 1 || $("#stayingWith").val() == 2){
            $("#guardianInfoGroup").fadeOut(200);
        }else{
            $("#guardianInfoGroup").fadeIn(200);
        }
    });
});
</script>
@endsection
