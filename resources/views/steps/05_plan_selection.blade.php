@extends('layouts.master')

@section('title', 'เลือกแผนการเรียน')

@section('content')
<legend><i class="fa fa-institution"></i> เลือกแผนการเรียน <i class="fa fa-spinner fa-spin text-muted pull-right" style="display:none;" id="loadingSpinner"></i></legend>
<div class="row">
    <div class="col-md-12" id="applicationTypeCol">
        <span class="help-block">ประเภทการสมัคร</span>
        <select id="application_type" name="application_type" style="width:100%;" class="form-control select select-primary select-block mbl">
            <option value="0">นักเรียนปกติ</option>
            <option value="1">นักเรียนความสามารถพิเศษ (โควตา)</option>
            <option value="2">นักเรียนในโครงการโควตาจังหวัด สพม.</option>
        </select>
    </div>
    <div class="col-md-7" style="display:none;" id="quotaTypeCol">
        <span class="help-block">ประเภทโควตา</span>
        <select id="quota_type" name="quota_type" style="width:100%;" class="form-control select select-primary select-block mbl">
            {{ App\Http\Controllers\Helper::printQuotaSelectBox() }}
        </select>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <span class="help-block">แผนการเรียนที่นักเรียนต้องการสมัคร</span>
        <select id="plan" name="plan" style="width:100%;" class="form-control select select-primary select-block mbl">
            <?php
                $currentPlanSelected = 5; // TODO: Dynamically load this!
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
@endsection

@section('additional_scripts')
<script>

var lang_chinese_in_list = 1;

$(function(){
    $("#application_type").change();
    $("#quota_type").change();
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

function sortSelectBox(){
    var selectList = $('#plan option');
    selectList.sort(function(a,b){
        a = a.value;
        b = b.value;
        return a-b;
    });
    $('#plan').html(selectList);
}

</script>
@endsection
