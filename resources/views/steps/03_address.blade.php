@extends('layouts.master')

@section('title', 'ที่อยู่และภูมิลำเนา')

@section('content')
<legend><i class="fa fa-map-marker"></i> ที่อยู่และภูมิลำเนา <i class="fa fa-spinner fa-spin text-muted pull-right" style="display:none;" id="loadingSpinner"></i></legend>
<div class="row">
    <div class="col-xs-12">
        <p class="badge" style="font-size:.9em;font-weight:normal;">&nbsp;&nbsp; ที่อยู่ตามทะเบียนบ้าน &nbsp;&nbsp;</p>
        <div class="row">
            <div class="col-md-3 col-xs-12" id="home_addressGroup">
                <span class="help-block">บ้านเลขที่</span>
                <input id="home_address" type="text" placeholder="บ้านเลขที่" class="form-control">
            </div>
            <div class="col-md-3 col-xs-12" id="home_mooGroup">
                <span class="help-block">หมู่</span>
                <input id="home_moo" type="text" placeholder="หากไม่มีให้ใส่ขีด (-)" class="form-control">
            </div>
            <div class="col-md-3 col-xs-12" id="home_soiGroup">
                <span class="help-block">ซอย</span>
                <input id="home_soi" type="text" placeholder="หากไม่มีให้ใส่ขีด (-)" class="form-control">
            </div>
            <div class="col-md-3 col-xs-12" id="home_roadGroup">
                <span class="help-block">ถนน</span>
                <input id="home_road" type="text" placeholder="หากไม่มีให้ใส่ขีด (-)" class="form-control">
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-xs-12" id="home_subdistrictGroup">
                <span class="help-block">แขวง / ตำบล</span>
                <input id="home_subdistrict" type="text" placeholder="แขวง / ตำบล" class="form-control">
                <?php // TODO : change home_subdistrict to be select ?>
            </div>
            <div class="col-md-3 col-xs-12" id="home_districtGroup">
                <span class="help-block">เขต / อำเภอ</span>
                <input id="home_district" type="text" placeholder="เขต / อำเภอ" class="form-control">
                <?php // TODO : change home_district to be select ?>
            </div>
            <div class="col-md-3 col-xs-12">
                <span class="help-block">จังหวัด</span>
                <select id="home_province" name="home_province" class="form-control select select-primary select-block mbl">
                    {{ App\Http\Controllers\Helper::printProvinceOptions(isset($applicantData['address']['home']['province']) ? $applicantData['address']['home']['province'] : NULL) }}
                </select>
            </div>
            <div class="col-md-3 col-xs-12" id="home_postcodeGroup">
                <span class="help-block">รหัสไปรษณีย์</span>
                <input id="home_postcode" type="text" class="form-control" placeholder="รหัสไปรษณีย์" maxlength="5">
            </div>
        </div>
        @if(Config::get('uiconfig.mode') == 'province_quota')
            <div class="row">
                <div class="col-md-12">
                    <span class="help-block">วันที่ย้ายเข้า</span>
                    <div class="row">
                        <div class="col-xs-4">
                            <select id="address_move_in_date" name="address_move_in_date" style="width:100%;" class="form-control select select-primary select-block mbl">
                                <?php
                                    $date = 1;
                                    while($date <= 31){
                                        echo("<option value=\"$date\">$date</option>");
                                        $date++;
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-xs-4">
                            <select id="address_move_in_month" name="address_move_in_month" style="width:100%;" class="form-control select select-primary select-block mbl">
                                <option value="1">มกราคม</option>
                                <option value="2">กุมภาพันธ์</option>
                                <option value="3">มีนาคม</option>
                                <option value="4">เมษายน</option>
                                <option value="5">พฤษภาคม</option>
                                <option value="6">มิถุนายน</option>
                                <option value="7">กรกฎาคม</option>
                                <option value="8">สิงหาคม</option>
                                <option value="9">กันยายน</option>
                                <option value="10">ตุลาคม</option>
                                <option value="11">พฤศจิกายน</option>
                                <option value="12">ธันวาคม</option>
                            </select>
                        </div>
                        <div class="col-xs-4">
                            <select id="address_move_in_year" name="address_move_in_year" style="width:100%;" class="form-control select select-primary select-block mbl">
                                <?php
                                    $year = date("Y") + 543; // Assuming that "date" will be in Christian Era.
                                    $threshold = 30;
                                    while($threshold >= 0){
                                        echo("<option value=\"$year\">$year</option>");
                                        $year -= 1;
                                        $threshold -= 1;
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
<br />
<div class="row">
    <div class="col-xs-12">
        <p class="badge" style="font-size:.9em;font-weight:normal;">&nbsp;&nbsp; ที่อยู่ปัจจุบัน &nbsp;&nbsp;</p>
        <div class="row">
            <div class="col-xs-12">
                <label class="checkbox"><input type="checkbox" id="copy_address" name="copy_address" {{ isset($applicantData['current_address_same_as_home']) && $applicantData['current_address_same_as_home'] == "1" ? "checked" : "" }}> ใช้ที่อยู่เดียวกับที่อยู่ตามทะเบียนบ้าน</label>
            </div>
        </div>
        <div id="current_address_form">
            <div class="row">
                <div class="col-md-3 col-xs-12" id="current_addressGroup">
                    <span class="help-block">บ้านเลขที่</span>
                    <input id="current_address" type="text" placeholder="บ้านเลขที่" class="form-control">
                </div>
                <div class="col-md-3 col-xs-12" id="current_mooGroup">
                    <span class="help-block">หมู่</span>
                    <input id="current_moo" type="text" placeholder="หากไม่มีให้ใส่ขีด (-)" class="form-control">
                </div>
                <div class="col-md-3 col-xs-12" id="current_soiGroup">
                    <span class="help-block">ซอย</span>
                    <input id="current_soi" type="text" placeholder="หากไม่มีให้ใส่ขีด (-)" class="form-control">
                </div>
                <div class="col-md-3 col-xs-12" id="current_roadGroup">
                    <span class="help-block">ถนน</span>
                    <input id="current_road" type="text" placeholder="หากไม่มีให้ใส่ขีด (-)" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-xs-12" id="current_subdistrictGroup">
                    <span class="help-block">แขวง / ตำบล</span>
                    <input id="current_subdistrict" type="text" placeholder="แขวง / ตำบล" class="form-control">
                    <?php // TODO : change home_subdistrict to be select ?>
                </div>
                <div class="col-md-3 col-xs-12" id="current_districtGroup">
                    <span class="help-block">เขต / อำเภอ</span>
                    <input id="current_district" type="text" placeholder="เขต / อำเภอ" class="form-control">
                    <?php // TODO : change home_district to be select ?>
                </div>
                <div class="col-md-3 col-xs-12">
                    <span class="help-block">จังหวัด</span>
                    <select id="current_province" name="current_province" class="form-control select select-primary select-block mbl">
                        {{ App\Http\Controllers\Helper::printProvinceOptions(isset($applicantData['address']['current']['province']) ? $applicantData['address']['current']['province'] : NULL) }}
                    </select>
                </div>
                <div class="col-md-3 col-xs-12" id="current_postcodeGroup">
                    <span class="help-block">รหัสไปรษณีย์</span>
                    <input id="current_postcode" type="text" placeholder="รหัสไปรษณีย์" class="form-control" maxlength="5">
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

var currentAddressCopied = 0;
var currentAddressGroupShown = 1;

$(function(){
    $("#copy_address").change();
})

$('#copy_address').on('change',function(){
    if($("#copy_address").is(":checked")){
        currentAddressCopied = 1;
        if(currentAddressGroupShown == 1){
            $("#current_address_form").fadeOut(200);
            currentAddressGroupShown = 0;
        }
    }else{
        currentAddressCopied = 0;
        if(currentAddressGroupShown == 0){
            $("#current_address_form").fadeIn(200);
            currentAddressGroupShown = 1;
        }
    }
});

$("#sendTheFormButton").click(function(){

    // Tell the user to wait:
    $('#plsWaitModal').modal('show');

    // Error checking variable
    var hasErrors = 0;

    // Check father information inputs
    hasErrors += isFieldBlank("home_address");
    hasErrors += isFieldBlank("home_moo");
    hasErrors += isFieldBlank("home_soi");
    hasErrors += isFieldBlank("home_road");
    hasErrors += isFieldBlank("home_subdistrict");
    hasErrors += isFieldBlank("home_district");
    hasErrors += isFieldBlank("home_postcode");

    if(currentAddressCopied != 1){
        hasErrors += isFieldBlank("current_address");
        hasErrors += isFieldBlank("current_moo");
        hasErrors += isFieldBlank("current_soi");
        hasErrors += isFieldBlank("current_road");
        hasErrors += isFieldBlank("current_subdistrict");
        hasErrors += isFieldBlank("current_district");
        hasErrors += isFieldBlank("current_postcode");
    }

    // Prepare data:
    if(currentAddressCopied == 1){
        // Address should be copied over:
        var addressData = {
            _token: csrfToken,
            home_address: $("#home_address").val(),
            home_moo: $("#home_moo").val(),
            home_soi: $("#home_soi").val(),
            home_road: $("#home_road").val(),
            home_subdistrict: $("#home_subdistrict").val(),
            home_district: $("#home_district").val(),
            home_province: $("#home_province").val(),
            current_address: $("#home_address").val(),
            current_moo: $("#home_moo").val(),
            current_soi: $("#home_soi").val(),
            current_road: $("#home_road").val(),
            current_subdistrict: $("#home_subdistrict").val(),
            current_district: $("#home_district").val(),
            current_province: $("#home_province").val(),
            current_postcode: $("#home_postcode").val(),
            current_address_same_as_home: "1"
        }
    }else{
        // Nope, a different address will be used:
        var addressData = {
            _token: csrfToken,
            home_address: $("#home_address").val(),
            home_moo: $("#home_moo").val(),
            home_soi: $("#home_soi").val(),
            home_road: $("#home_road").val(),
            home_subdistrict: $("#home_subdistrict").val(),
            home_district: $("#home_district").val(),
            home_province: $("#home_province").val(),
            current_address: $("#current_address").val(),
            current_moo: $("#current_moo").val(),
            current_soi: $("#current_soi").val(),
            current_road: $("#current_road").val(),
            current_subdistrict: $("#current_subdistrict").val(),
            current_district: $("#current_district").val(),
            current_province: $("#current_province").val(),
            current_postcode: $("#current_postcode").val(),
            current_address_same_as_home: "0"
        }
    }

    @if(Config::get('app.debug') === true)
        console.log("[DBG/LOG] Total errors: " + hasErrors);
    @endif

    if(hasErrors == 0){
        // Green across the board, and ready for action!
        $.ajax({
            url: '/api/v1/applicant/address',
            data: addressData,
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
        // NOPE.
        $('#plsWaitModal').modal('hide');
        notify("<i class='fa fa-exclamation-triangle text-warning'></i> มีข้อผิดพลาดของข้อมูล โปรดตรวจสอบรูปแบบข้อมูลอีกครั้ง", "warning");
    }

});
</script>
@endsection
