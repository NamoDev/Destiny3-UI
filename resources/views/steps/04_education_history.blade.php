@extends('layouts.master')

@section('title', 'ประวัติการศึกษา')

@section('content')

<legend><i class="fa fa-graduation-cap"></i> ประวัติการศึกษา <i class="fa fa-spinner fa-spin text-muted pull-right" style="display:none;" id="loadingSpinner"></i></legend>

<div class="row">
    <div class="col-md-6 col-xs-12" id="schoolGroup">
        <span class="help-block">จบการศึกษาระดับชั้น<b>มัธยมศึกษาปีที่ 3</b> จากโรงเรียน</span>
        <input id="school" name="school" placeholder="ชื่อโรงเรียน" class="form-control twitter-typeahead" value="{{ isset($applicantData['school']) ? $applicantData['school'] : ''}}" />
    </div>
    <div class="col-md-3 col-xs-12">
        <span class="help-block">ปีที่จบหรือคาดว่าจะจบการศึกษา</span>
        <select id="graduation_year" name="graduation_year" class="form-control select select-primary select-block mbl">
        <?php
            $year = date("Y") + 543; // Assuming that "date" will be in Christian Era.
            $threshold = 30;

            // See if we got any data:
            if(isset($applicantData['graduation_year'])){
                // Yeah:
                while($threshold >= 0){
                    if($year == $applicantData['graduation_year']){
                        echo("<option value=\"$year\" selected>$year</option>");
                    }else{
                        echo("<option value=\"$year\">$year</option>");
                    }
                    $year -= 1;
                    $threshold -= 1;
                }
            }else{
                // Nope.
                while($threshold >= 0){
                    echo("<option value=\"$year\">$year</option>");
                    $year -= 1;
                    $threshold -= 1;
                }
            }
        ?>
        </select>
    </div>
    <div class="col-md-3 col-xs-12" id="gpaGroup">
        <span class="help-block">เกรดเฉลี่ยสะสม</span>
        <input id="gpa" name="gpa" type="text" placeholder="GPA ในรูปแบบ 0.00" class="form-control" value="{{ isset($applicantData['gpa']) ? $applicantData['gpa'] : ''}}" />
    </div>
</div>

{{-- School move in date section, for use with Province Quota Operation Mode only --}}
@if(Config::get("uiconfig.mode") == "province_quota")
<div class="row">
    <div class="col-md-6">
        <span class="help-block">วันที่เริ่มเข้าศึกษา</span>
        <div class="row">
            <div class="col-xs-4">
                <select id="moveinDay" name="moveinDay" class="form-control select select-primary select-block Wmbl">
                    <?php
                        $date = 1;
                        // See if we already have data:
                        if(isset($applicantData['school_move_in']['day'])){
                            // Yep. Continue:
                            while($date <= 31){
                                if($date == $applicantData['school_move_in']['day']){
                                    echo("<option value=\"$date\" selected>$date</option>");
                                }else{
                                    echo("<option value=\"$date\">$date</option>");
                                }
                                $date++;
                            }
                        }else{
                            // NOPE!
                            while($date <= 31){
                                echo("<option value=\"$date\">$date</option>");
                                $date++;
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="col-xs-4">
                <select id="moveinMonth" name="moveinMonth" class="form-control select select-primary select-block mbl">
                    <?php
                        $months = [
                            1 => "มกราคม",
                            2 => "กุมภาพันธ์",
                            3 => "มีนาคม",
                            4 => "เมษายน",
                            5 => "พฤษภาคม",
                            6 => "มิถุนายน",
                            7 => "กรกฎาคม",
                            8 => "สิงหาคม",
                            9 => "กันยายน",
                            10 => "ตุลาคม",
                            11 => "พฤศจิกายน",
                            12 => "ธันวาคม"
                        ];

                        // See if we already have data:
                        if(isset($applicantData['school_move_in']['month'])){
                            foreach($months as $month_id => $month_name){
                                if($month_id == $applicantData['school_move_in']['month']){
                                    echo("<option value=\"$month_id\" selected>$month_name</option>");
                                }else{
                                    echo("<option value=\"$month_id\">$month_name</option>");
                                }
                            }
                        }else{
                            // Nope.
                            foreach($months as $month_id => $month_name){
                                echo("<option value=\"$month_id\">$month_name</option>");
                            }
                        }
                     ?>
                </select>
            </div>
            <div class="col-xs-4">
                <select id="moveinYear" name="moveinYear" class="form-control select select-primary select-block mbl">
                    <?php
                        $year = date("Y") + 543; // Assuming that "date" will be in Christian Era.
                        $threshold = 30;

                        // See if we already have data:
                        if(isset($applicantData['school_move_in']['year'])){
                            while($threshold >= 0){
                                if($year == $applicantData['school_move_in']['year']){
                                    echo("<option value=\"$year\" selected>$year</option>");
                                }else{
                                    echo("<option value=\"$year\">$year</option>");
                                }
                                $year -= 1;
                                $threshold -= 1;
                            }
                        }else{
                            // Nope:
                            while($threshold >= 0){
                                echo("<option value=\"$year\">$year</option>");
                                $year -= 1;
                                $threshold -= 1;
                            }
                        }
                    ?>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <span class="help-block">จังหวัด (โรงเรียน)</span>
        <select id="schoolProvince" name="schoolProvince" class="form-control select select-primary select-block mbl">
            {{ App\Http\Controllers\Helper::printProvinceOptions(isset($applicantData['school_province']) ? isset($applicantData['school_province']) : NULL) }}
        </select>
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
@endif

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
    hasErrors += isFieldBlank("school");

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
                school: $("#school").val(),
                graduation_year: $("#graduation_year").val(),
                gpa: $("#gpa").val(),
                {{-- Additional data for province quota applicants: --}}
                @if(Config::get("uiconfig.mode") == "province_quota")
                    school_move_in_day: $("#moveinDay").val(),
                    school_move_in_month: $("#moveinMonth").val(),
                    school_move_in_year: $("#moveinYear").val(),
                    school_province: $("#schoolProvince").val(),
                @endif
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

            },
            type: 'POST'
        });
    }else{
        // O NOES!
        $('#plsWaitModal').modal('hide');
        notify("<i class='fa fa-exclamation-triangle text-warning'></i> มีข้อผิดพลาดของข้อมูล โปรดตรวจสอบรูปแบบข้อมูลอีกครั้ง", "warning");
    }




});

var schoolsList = new Bloodhound({
  datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.word); },
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  limit: 4,
  local: [
      { word: "เตรียมอุดมศึกษา" },
      { word: "เตรียมอุดมศึกษา ภาคเหนือ" },
      { word: "เตรียมอุดมศึกษา ภาคตะวันออกเฉียงเหนือ" },
      { word: "เตรียมอุดมศึกษา ภาคใต้" },
      { word: "เตรียมอุดมศึกษาน้อมเกล้า" },
      { word: "เตรียมอุดมศึกษาน้อมเกล้า กบินทร์บุรี" },
      { word: "เตรียมอุดมศึกษาน้อมเกล้า นนทบุรี" },
      { word: "เตรียมอุดมศึกษาน้อมเกล้า นครราชสีมา" },
      { word: "เตรียมอุดมศึกษาน้อมเกล้า ปทุมธานี" },
      { word: "เตรียมอุดมศึกษาน้อมเกล้า สมุทรปราการ" },
      { word: "เตรียมอุดมศึกษาน้อมเกล้า อุตรดิตถ์" },
      { word: "เตรียมอุดมศึกษาเปร็งวิสุทธาธิบดี" },
      { word: "เตรียมอุดมศึกษาพัฒนาการ" },
      { word: "เตรียมอุดมศึกษาพัฒนาการ ขอนแก่น" },
      { word: "เตรียมอุดมศึกษาพัฒนาการ ฉะเชิงเทรา" },
      { word: "เตรียมอุดมศึกษาพัฒนาการ เชียงราย" },
      { word: "เตรียมอุดมศึกษาพัฒนาการ ดอนคลัง" },
      { word: "เตรียมอุดมศึกษาพัฒนาการ นนทบุรี" },
      { word: "เตรียมอุดมศึกษาพัฒนาการ สระบุรี" },
      { word: "เตรียมอุดมศึกษาพัฒนาการ ปราณบุรี" },
      { word: "เตรียมอุดมศึกษาพัฒนาการ ปทุมธานี" },
      { word: "เตรียมอุดมศึกษาพัฒนาการ สุวรรณภูมิ" },
      { word: "เตรียมอุดมศึกษาพัฒนาการ รัชดา" },
      { word: "เตรียมอุดมศึกษาพัฒนาการ อุดรธานี" },
      { word: "เตรียมอุดมศึกษาพัฒนาการ อุบลราชธานี" },
      { word: "เตรียมอุดมศึกษาสุวินทวงศ์" }
  ]
});

schoolsList.initialize();

$('#school').typeahead(null, {
  name: 'schoolsList',
  displayKey: 'word',
  highlight: true,
  source: schoolsList.ttAdapter()
});

</script>
@endsection
