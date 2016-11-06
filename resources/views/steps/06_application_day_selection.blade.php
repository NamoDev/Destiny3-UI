@extends('layouts.master')

@section('title', 'เลือกวันสมัคร')

@section('content')
<legend><i class="fa fa-calendar-check-o"></i> เลือกวันสมัคร <i class="fa fa-spinner fa-spin text-muted pull-right" style="display:none;" id="loadingSpinner"></i></legend>

<div class="row">
@foreach($applicationDays as $i=>$applicationDay)
    <div class="col-md-6">
        <div class="well btnWell text-center">
            <h6 style="margin:0;"><b>{{$applicationDay["display"]}}</b></h6>
            <br />
            <div class="row">
                <div class="col-xs-6">
                    <b>08:30 - 12:00</b><br />
                    @if(isset($applicantData["application_day"]) and $applicantData["application_day"] == $applicationDay["date"] . "/morning")
                        <br />
                        <small class="text-success"><i class="fa fa-check-circle"></i> <b>เลือกสมัครรอบนี้แล้ว</b></small><br />
                    @else
                        @if($applicationDay["morning_count"] < $applicationDay["morning_max"])
                            <small class="text-success">ยังมีที่ว่าง</small><br />
                            <button class="btn btn-block btn-primary" id="adsel_{{base64_encode($applicationDay["date"] . "/morning")}}" style="margin-top:10px;">เลือกสมัครรอบนี้</button>
                        @else
                            <small class="text-danger">เต็มแล้ว</small><br />
                            <button class="btn btn-block btn-primary disabled" style="margin-top:10px;">เลือกสมัครรอบนี้</button>
                        @endif
                    @endif
                </div>
                <div class="col-xs-6">
                    <b>13:00 - 16:30</b><br />
                    @if(isset($applicantData["application_day"]) and $applicantData["application_day"] == $applicationDay["date"] . "/afternoon")
                        <br />
                        <small class="text-success"><i class="fa fa-check-circle"></i> <b>เลือกสมัครรอบนี้แล้ว</b></small><br />
                    @else
                        @if($applicationDay["afternoon_count"] < $applicationDay["afternoon_max"])
                            <small class="text-success">ยังมีที่ว่าง</small><br />
                            <button class="btn btn-block btn-primary" id="adsel_{{base64_encode($applicationDay["date"] . "/morning")}}" style="margin-top:10px;">เลือกสมัครรอบนี้</button>
                        @else
                            <small class="text-danger">เต็มแล้ว</small><br />
                            <button class="btn btn-block btn-primary disabled" style="margin-top:10px;">เลือกสมัครรอบนี้</button>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endforeach
</div>
<div class="row">
    <div class="col-xs-6 col-md-8">
        <span id="formAlertMessage" style="display:none;"></span>
    </div>
</div>
@endsection

@section('additional_scripts')
<script>
$("[id^=adsel_]").click(function(t){
    $.ajax({
        url: '/api/v1/applicant/application_day',
        data: {
            _token: csrfToken,
            id: t.target.id
        },
        error: function (request, status, error) {
            $("#plsWaitModal").modal("hide");
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
            $("#plsWaitModal").modal("hide");
            notify("<i class='fa fa-check'></i> บันทึกข้อมูลเรียบร้อย", "success");

        },
        type: 'POST'
    });
});
</script>
@endsection
