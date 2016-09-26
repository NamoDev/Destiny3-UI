@extends('layouts.master')

@section('title', 'ที่อยู่และภูมิลำเนา')

@section('content')
<legend><i class="fa fa-map-marker"></i> ที่อยู่และภูมิลำเนา <i class="fa fa-spinner fa-spin text-muted pull-right" style="display:none;" id="loadingSpinner"></i></legend>
<div class="row">
    <div class="col-xs-12">
        <p class="badge" style="font-size:.9em;font-weight:normal;">&nbsp;&nbsp; ที่อยู่ตามทะเบียนบ้าน &nbsp;&nbsp;</p>
        <div class="row">
            <div class="col-md-3 col-xs-12">
                <span class="help-block">บ้านเลขที่</span>
                <input name="home_address" type="text" placeholder="บ้านเลขที่" class="form-control">
            </div>
            <div class="col-md-3 col-xs-12">
                <span class="help-block">หมู่</span>
                <input name="home_moo" type="text" placeholder="หากไม่มีให้ใส่ขีด (-)" class="form-control">
            </div>
            <div class="col-md-3 col-xs-12">
                <span class="help-block">ซอย</span>
                <input name="home_soi" type="text" placeholder="หากไม่มีให้ใส่ขีด (-)" class="form-control">
            </div>
            <div class="col-md-3 col-xs-12">
                <span class="help-block">ถนน</span>
                <input name="home_road" type="text" placeholder="หากไม่มีให้ใส่ขีด (-)" class="form-control">
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-xs-12">
                <span class="help-block">แขวง / ตำบล</span>
                <input name="home_subdistrict" type="text" placeholder="หากไม่มีให้ใส่ขีด (-)" class="form-control">
                <?php // TODO : change home_subdistrict to be select ?>
            </div>
            <div class="col-md-3 col-xs-12">
                <span class="help-block">เขต / อำเภอ</span>
                <input name="home_district" type="text" placeholder="หากไม่มีให้ใส่ขีด (-)" class="form-control">
                <?php // TODO : change home_district to be select ?>
            </div>
            <div class="col-md-3 col-xs-12">
                <span class="help-block">จังหวัด</span>
                <input name="home_province" type="text" placeholder="หากไม่มีให้ใส่ขีด (-)" class="form-control">
                <?php // TODO : change home_province to be select ?>
            </div>
            <div class="col-md-3 col-xs-12">
                <span class="help-block">รหัสไปรษณีย์</span>
                <input name="home_postcode" type="text" placeholder="หากไม่มีให้ใส่ขีด (-)" class="form-control">
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
            <div class="col-md-3 col-xs-4">
                <span class="help-block">บ้านเลขที่</span>
                <input name="current_address" type="text" placeholder="บ้านเลขที่" class="form-control">
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional_scripts')

@endsection
