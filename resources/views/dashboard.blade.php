@extends('layouts.master')
@section('title', 'หน้าหลัก')

@section('content')
{{--
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
        @if(Applicant::quotaSubmissionUnderReview())
            อยู่ระหว่างการตรวจเอกสาร
        @elseif(isset(Applicant::current()['quota_being_evaluated']) &&
                Applicant::current()['quota_being_evaluated'] == 0 &&
                isset(Applicant::current()['evaluation_status']) &&
                Applicant::current()['evaluation_status'] == 0)
            การสมัครยังไม่สมบูรณ์
        @elseif(isset(Applicant::current()['quota_being_evaluated']) &&
                Applicant::current()['quota_being_evaluated'] == 1 &&
                isset(Applicant::current()['evaluation_status']) &&
                Applicant::current()['evaluation_status'] == 1)
            การสมัครเสร็จสมบูรณ์
        @else
            การสมัครยังไม่สมบูรณ์
        @endif
    </div>
</div>
@endsection
