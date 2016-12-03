@extends('layouts.master')
@section('title', 'ข้อมูลพื้นฐาน')


@section('content')

<legend><i class="fa fa-user"></i> ข้อมูลพื้นฐาน <i class="fa fa-spinner fa-spin text-muted pull-right" style="display:none;" id="loadingSpinner"></i></legend>

<div class="row">
    <div class="col-md-3 col-xs-4">
        <span class="help-block">คำนำหน้าชื่อ</span>
        <div id="titleGroup">
            <select id="title" name="title" class="form-control select select-primary select-block mbl">
                <optgroup label="คำนำหน้าชื่อ">
                    <?php
                        $titleArray = [
                            "ด.ช.",
                            "ด.ญ.",
                            "นาย",
                            "นางสาว",
                            "อื่นๆ",
                        ];
                        foreach($titleArray as $key => $value){
                            if(!is_numeric($applicantData['title'])){
                                if($key == 4){
                                    echo("<option value=\"$key\" selected>$value</option>");
                                }else{
                                    echo("<option value=\"$key\">$value</option>");
                                }
                            }else{
                                if($key == $applicantData['title']){
                                    echo("<option value=\"$key\" selected>$value</option>");
                                }else{
                                    echo("<option value=\"$key\">$value</option>");
                                }
                            }
                        }
                    ?>
                </optgroup>
            </select>
        </div>
        <div id="customtitleGroup" style="display:none;">
            <input id="customtitle" name="customtitle" type="text" placeholder="คำนำหน้าชื่อ" value="@if(!is_numeric($applicantData['title'])){{ $applicantData['title'] }}@endif" class="form-control" />
            <span class="small text-muted"><a href="#" id="cancelCustomTitleSelection"><i class="fa fa-times"></i> กลับไปเลือกคำนำหน้าชื่อปกติ</a></span>
        </div>
    </div>
    <div class="col-md-4 col-xs-8" id="fnameGroup">
        <span class="help-block">ชื่อ</span>
        <input id="fname" name="fname" type="text" placeholder="ชื่อ" class="form-control" value="{{ $applicantData['fname'] }}" />
    </div>
    <div class="col-md-5 col-xs-12" id="lnameGroup">
        <span class="help-block">นามสกุล</span>
        <input id="lname" name="lname" type="text" placeholder="นามสกุล" value="{{ $applicantData['lname'] }}" class="form-control" />
    </div>
</div>
<!-- == -->
<div class="row">
    <div class="col-md-3 col-xs-4">
        <div id="customtitle_enGroup" style="display:none;">
          <span class="help-block">คำนำหน้าชื่อ (ภาษาอังกฤษ)</span>
              <input id="customtitle_en" name="customtitle_en" type="text" placeholder="Title" value="@if(!is_numeric($applicantData['title'])){{ $applicantData['title_en'] }}@endif" class="form-control" />
        </div>
    </div>
    <div class="col-md-4 col-xs-8" id="fname_enGroup">
        <span class="help-block">ชื่อ (ภาษาอังกฤษ)</span>
        <input id="fname_en" name="fname_en" type="text" placeholder="First name" value="{{ $applicantData['fname_en'] }}" class="form-control" />
    </div>
    <div class="col-md-5 col-xs-12" id="lname_enGroup">
        <span class="help-block">นามสกุล (ภาษาอังกฤษ)</span>
        <input id="lname_en" name="lname_en" type="text" placeholder="Last name" value="{{ $applicantData['lname_en'] }}" class="form-control" />
    </div>
</div>
<!-- == -->
<div class="row">
    <div class="col-md-3" id="customGenderGroup" style="display:none;">
        <span class="help-block">เพศ</span>
        <select id="customGender" name="customGender" class="form-control select select-primary select-block mbl">
            <optgroup label="เลือกเพศ">
                <?php
                    $genders = ['ชาย', 'หญิง'];
                    foreach($genders as $key => $gender){
                        if($key == $applicantData['gender']){
                            echo("<option value=\"$key\" selected>$gender</option>");
                        }else{
                            echo("<option value=\"$key\">$gender</option>");
                        }
                    }
                ?>
            </optgroup>
        </select>
    </div>
    <div class="col-md-12" id="citizenidGroup">
        <span class="help-block">รหัสประจำตัวประชาชน</span>
        <input type="text" class="form-control" id="cidDisplay" value="{{ App\Http\Controllers\Helper::formatCitizenIDforDisplay(Session::get("applicant_citizen_id")) }}" />
    </div>
</div>
<!-- == -->
<div class="row">
    <div class="col-md-12">
        <span class="help-block">วัน เดือน ปีเกิด</span>
        <div class="row">
            <div class="col-xs-4">
                <select id="birthdate" name="birthdate" style="width:100%;" class="form-control select select-primary select-block mbl">
                    <?php
                        $date = 1;
                        while($date <= 31){
                            if($date == $applicantData['birthdate']['day']){
                                echo("<option value=\"$date\" selected>$date</option>");
                            }else{
                                echo("<option value=\"$date\">$date</option>");
                            }
                          $date++;
                        }
                    ?>
                </select>
            </div>
            <div class="col-xs-4">
                <select id="birthmonth" name="birthmonth" style="width:100%;" class="form-control select select-primary select-block mbl">
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

                        foreach($months as $month_id => $month_name){
                            if($month_id == $applicantData['birthdate']['month']){
                                echo("<option value=\"$month_id\" selected>$month_name</option>");
                            }else{
                                echo("<option value=\"$month_id\">$month_name</option>");
                            }
                        }

                     ?>
                </select>
            </div>
            <div class="col-xs-4">
                <select id="birthyear" name="birthyear" style="width:100%;" class="form-control select select-primary select-block mbl">
                    <?php
                        $year = date("Y") + 543; // Assuming that "date" will be in Christian Era.
                        $threshold = 30;
                        if(config('uiconfig.mode') == 'province_quota'){
                            $year-=13;
                            $threshold = 2;
                        }
                        while($threshold >= 0){
                            if($year == $applicantData['birthdate']['year']){
                                echo("<option value=\"$year\" selected>$year</option>");
                            }else{
                                echo("<option value=\"$year\">$year</option>");
                            }
                            $year -= 1;
                            $threshold -= 1;
                        }
                    ?>
                </select>
            </div>
        </div>
    </div>
</div>
<!-- == -->
<div class="row">
    <div class="col-md-12" id="emailGroup">
        <span class="help-block">E-mail address</span>
        <input id="email" name="email" type="email" placeholder="ที่อยู่อีเมล์ของนักเรียน" class="form-control" value="{{ $applicantData['email'] }}" />
    </div>
</div>
<div class="row">
    <div class="col-md-12" id="phoneGroup">
        <span class="help-block">หมายเลขโทรศัพท์</span>
        <input id="phone" name="phone" type="text" placeholder="หมายเลขโทรศัพท์ของนักเรียน" class="form-control" value="{{ $applicantData['phone'] }}" />
    </div>
</div>
<!-- == -->
<br />
<!-- == -->
<div class="row">
    <div class="col-xs-6 col-md-8">
        <span id="formAlertMessage" style="display:none;"></span>
    </div>
    <div class="col-xs-6 col-md-4">
        <button id="sendTheFormButton" class="btn btn-block btn-info">บันทึกข้อมูล</button>
    </div>
</div>
<!-- == -->
@endsection
@section('additional_scripts')
<script>
    $(function(){
        $("#title").change();
    });

    /* Form submit */
    $("#sendTheFormButton").click(function(e){
        e.preventDefault();

        // Clear any notifications if applicable;
        clearNotifications();

        // Wait for it...
        $('#plsWaitModal').modal('show');

        // We need to verify the data first, and then give the user error hints if necessary:
        // But first, we'll need a variable to store error counts:
        var hasErrors = 0;

        // Check email
        if(checkEmail($("#email").val())){
            $("#emailGroup").removeClass("has-error");
        }else{
            $("#emailGroup").addClass("has-error");
            hasErrors += 1;
        }

        // These fields CANNOT be left blank:
        hasErrors += isFieldBlank("fname");
        hasErrors += isFieldBlank("lname");
        hasErrors += isFieldBlank("fname_en");
        hasErrors += isFieldBlank("lname_en");
        hasErrors += isFieldBlank("phone");

        // IF we're using custom titles:
        if(usingCustomTitle == 1){

            // If so, the title fields can't be left blank:
            hasErrors += isFieldBlank("customtitle");
            hasErrors += isFieldBlank("customtitle_en");

            // Prep gender data
            var titleToSend = $("#customtitle").val();
            var titleToSend_en = $("#customtitle_en").val();
            var genderToSend = $("#customGender").val();

        }else{
            // Prep gender data
            var genderToSend;
            var titleToSend = $("#title").val();
            var titleToSend_en =  $("#title").val();
            switch(parseInt($("#title").val())){
                case 0:
                    genderToSend = 0;
                break;
                case 1:
                    genderToSend = 1;
                break;
                case 2:
                    genderToSend = 0;
                break;
                case 3:
                    genderToSend = 1;
                break;
                default:
                    genderToSend = 0;
            }
        }

        // Ah, finally we've completed all checks. Now, are there any errors?

        @if(Config::get('app.debug') === true)
            console.log("[DBG/LOG] Total errors: " + hasErrors);
        @endif

        if(hasErrors == 0){
            // Green across the board, and ready for action!
            $.ajax({
                url: '/api/v1/applicant/data',
                data: {
                    _token: csrfToken,
                    customtitle: usingCustomTitle,
                    title: titleToSend,
                    fname: $("#fname").val(),
                    lname: $("#lname").val(),
                    title_en: titleToSend_en,
                    fname_en: $("#fname_en").val(),
                    lname_en: $("#lname_en").val(),
                    gender: genderToSend,
                    birthdate: $("#birthdate").val(),
                    birthmonth: $("#birthmonth").val(),
                    birthyear: $("#birthyear").val(),
                    email: $("#email").val(),
                    phone: $("#phone").val(),
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

    /* Custom Titles */
    $("#title").change(function(){
        checkCustomTitleSelection();
    });

    /* Live email validation */
    $("#email").keyup(function(){
        if(checkEmail($("#email").val())){
            $("#emailGroup").removeClass("has-warning");
            $("#emailGroup > .help-block > .fa").remove();
        }else{
            $("#emailGroup").addClass("has-warning");
            $("#emailGroup > .help-block > .fa").remove();
            $("#emailGroup > .help-block").prepend("<i class=\"fa fa-exclamation-circle\"></i> ");
        }
    });

    /* Validate Thai language name fields */
    $("#customtitle").keyup(function(){
        if(checkThai($("#customtitle").val())){
            $("#customtitleGroup").removeClass("has-warning");
            $("#customtitleGroup > .help-block > .fa").remove();
        }else{
            $("#customtitleGroup").addClass("has-warning");
            $("#customtitleGroup > .help-block > .fa").remove();
            $("#customtitleGroup > .help-block").prepend("<i class=\"fa fa-exclamation-circle\"></i> ");
        }
    });
    $("#fname").keyup(function(){
        if(checkThai($("#fname").val())){
            $("#fnameGroup").removeClass("has-warning");
            $("#fnameGroup > .help-block > .fa").remove();
        }else{
            $("#fnameGroup").addClass("has-warning");
            $("#fnameGroup > .help-block > .fa").remove();
            $("#fnameGroup > .help-block").prepend("<i class=\"fa fa-exclamation-circle\"></i> ");
        }
    });
    $("#lname").keyup(function(){
        if(checkThai($("#lname").val())){
            $("#lnameGroup").removeClass("has-warning");
            $("#lnameGroup > .help-block > .fa").remove();
        }else{
            $("#lnameGroup").addClass("has-warning");
            $("#lnameGroup > .help-block > .fa").remove();
            $("#lnameGroup > .help-block").prepend("<i class=\"fa fa-exclamation-circle\"></i> ");
        }
    });

    /* Validate English language name fields */
    $("#customtitle_en").keyup(function(){
        if(checkAlphanumeric($("#customtitle_en").val())){
            $("#customtitle_enGroup").removeClass("has-warning");
            $("#customtitle_enGroup > .help-block > .fa").remove();
        }else{
            $("#customtitle_enGroup").addClass("has-warning");
            $("#customtitle_enGroup > .help-block > .fa").remove();
            $("#customtitle_enGroup > .help-block").prepend("<i class=\"fa fa-exclamation-circle\"></i> ");
        }
    });
    $("#fname_en").keyup(function(){
        if(checkAlphanumeric($("#fname_en").val())){
            $("#fname_enGroup").removeClass("has-warning");
            $("#fname_enGroup > .help-block > .fa").remove();
        }else{
            $("#fname_enGroup").addClass("has-warning");
            $("#fname_enGroup > .help-block > .fa").remove();
            $("#fname_enGroup > .help-block").prepend("<i class=\"fa fa-exclamation-circle\"></i> ");
        }
    });
    $("#lname_en").keyup(function(){
        if(checkAlphanumeric($("#lname_en").val())){
            $("#lname_enGroup").removeClass("has-warning");
            $("#lname_enGroup > .help-block > .fa").remove();
        }else{
            $("#lname_enGroup").addClass("has-warning");
            $("#lname_enGroup > .help-block > .fa").remove();
            $("#lname_enGroup > .help-block").prepend("<i class=\"fa fa-exclamation-circle\"></i> ");
        }
    });

    /* Cancellation of custom title */
    $("#cancelCustomTitleSelection").click(function(e){
        e.preventDefault();
        $("#title").val("0");
        $("#title").change();
    });

    function checkCustomTitleSelection(){
        if($("#title").val() == 4){
            // Custom title
            $("#title").removeClass("select-block");
            $("#customtitleGroup").show();
            $("#customtitle_enGroup").show();
            $("#customGenderGroup").show();
            $("#citizenidGroup").removeClass("col-md-12").addClass("col-md-9");
            $("#titleGroup").hide();
            usingCustomTitle = 1;
        }else{
            // Normal
            $("#title").addClass("select-block");
            $("#customtitleGroup").hide();
            $("#customtitle_enGroup").hide();
            $("#customGenderGroup").hide();
            $("#citizenidGroup").removeClass("col-md-9").addClass("col-md-12");
            $("#titleGroup").show();
            usingCustomTitle = 0;
        }
    }

    $('#cidDisplay').keydown(function(e){
        e.preventDefault();
    });

</script>
@endsection
