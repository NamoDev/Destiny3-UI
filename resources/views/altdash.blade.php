@extends('layouts.single_form')
@section('title', 'หน้าหลัก')

@section('content')
{{--
    โรงเรียนเตรียมอุดมศึกษาจะประกาศเลขประจำตัวสอบและที่นั่งสอบ ภายในวันที่
    <div class="row">
        <div class="col-md-3">
            <span class="help-block" style="font-size:1em;">เลขที่นั่งสอบ</span>
            <h4 class="text-muted" style="margin-top:0px;">---</h4>
        </div>
        <div class="col-md-5">
            <span class="help-block" style="font-size:1em;">สถานที่สอบ</span>
            <h4 class="text-muted" style="margin-top:0px;">---</h4>
        </div>
        <div class="col-md-2">
            <span class="help-block" style="font-size:1em;">อาคาร</span>
            <h4 class="text-muted" style="margin-top:0px;">---</h4>
        </div>
        <div class="col-md-2">
            <span class="help-block" style="font-size:1em;">ห้อง</span>
            <h4 class="text-muted" style="margin-top:0px;">---</h4>
        </div>
    </div>
--}}
<div class="row">
    <div class="col-md-6 col-md-offset-3 text-center">
        สถานะการสมัคร :
        @if(isset(Applicant::current()['evaluation_status']) &&
            Applicant::current()['evaluation_status'] == 1)
            การสมัครเสร็จสมบูรณ์
        @elseif(isset(Applicant::current()['quota_being_evaluated']) &&
                Applicant::current()['quota_being_evaluated'] == 1 &&
                isset(Applicant::current()['evaluation_status']) &&
                Applicant::current()['evaluation_status'] == 0)
            อยู่ระหว่างการตรวจเอกสาร
        @else
            การสมัครยังไม่สมบูรณ์ กรุณาติดต่อ 02-252-7001 ต่อ 103 (กลุ่มบริหารวิชาการ)
        @endif
    </div>
</div>
@endsection
