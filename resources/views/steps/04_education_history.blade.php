@extends('layouts.master')

@section('title', 'ประวัติการศึกษา')

@section('content')

<legend><i class="fa fa-graduation-cap"></i> ประวัติการศึกษา <i class="fa fa-spinner fa-spin text-muted pull-right" style="display:none;" id="loadingSpinner"></i></legend>

<div class="row">
    <div class="col-md-6 col-xs-12" id="schoolGroup">
        <span class="help-block">จบการศึกษาระดับชั้นมัธยมศึกษาปีที่ 3 จากโรงเรียน</span>
        <input id="school" name="school" type="text" placeholder="ชื่อโรงเรียน" class="form-control" />
    </div>
    <div class="col-md-3 col-xs-12">
        <span class="help-block">ปีที่จบหรือคาดว่าจะจบการศึกษา</span>
        <select id="graduation_year" name="graduation_year" class="form-control select select-primary select-block mbl">
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
    <div class="col-md-3 col-xs-12" id="gpaGroup">
        <span class="help-block">เกรดเฉลี่ยสะสม</span>
        <input id="gpa" name="gpa" type="text" placeholder="GPA ในรูปแบบ 0.00" class="form-control" />
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

                </select>
            </div>
            <div class="col-xs-4">
                <select id="moveinMonth" name="moveinMonth" class="form-control select select-primary select-block mbl">

                </select>
            </div>
            <div class="col-xs-4">
                <select id="moveinYear" name="moveinYear" class="form-control select select-primary select-block mbl">

                </select>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <span class="help-block">จังหวัด (โรงเรียน)</span>

    </div>
</div>
@endif

@endsection

@section('additional_scripts')

@endsection
