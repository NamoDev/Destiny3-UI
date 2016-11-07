@extends('layouts.master')

@section('title', 'อัพโหลดเอกสารประกอบ')

@section('content')
<legend><i class="fa fa-upload"></i> อัพโหลดเอกสารประกอบ <i class="fa fa-spinner fa-spin text-muted pull-right" style="display:none;" id="loadingSpinner"></i></legend>

<div class="row">
    <div class="col-md-6">
        <b>รูปถ่าย</b> ขนาด 1.5 นิ้ว
        <form action="/file-upload" class="dropzone" id="file_picture"></form>
    </div>
    <div class="col-md-6">
        <b>บัตรประจำตัวประชาชน</b>
        <form action="/file-upload" class="dropzone" id="file_citizen_id_card"></form>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-6">
        <b>ใบ ปพ.1</b> (5 ภาคเรียน)
        <form action="/file-upload" class="dropzone" id="file_transcript"></form>
    </div>
    <div class="col-md-6">
        <b>สำเนาทะเบียนบ้าน</b> ของนักเรียน
        <form action="/file-upload" class="dropzone" id="file_hr_applicant"></form>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-6">
        <b>สำเนาทะเบียนบ้าน</b> ของบิดา
        <form action="/file-upload" class="dropzone" id="file_hr_father"></form>
    </div>
    <div class="col-md-6">
        <b>สำเนาทะเบียนบ้าน</b> ของมารดา
        <form action="/file-upload" class="dropzone" id="file_hr_mother"></form>
    </div>
</div>
<br />
<div class="row">
    <div class="col-xs-6 col-md-8">
        <span id="formAlertMessage" style="display:none;"></span>
    </div>
</div>

@endsection

@section('additional_scripts')
<script src="/assets/js/dropzone.js"></script>
<script>
Dropzone.options.file_picture = {
  maxFilesize: 2, // MB
  maxFiles: 1,
  addRemoveLinks: true
};

/* Form submission */
$("#sendTheFormButton").click(function(){

    // Tell the user to wait:
    $('#plsWaitModal').modal('show');

    $.ajax({
        url: '/api/v1/applicant/documents_upload',
        data: {
            _token: csrfToken,
            transcript: $("#transcript").val(),
        },
        error: function (request, status, error) {
            $('#plsWaitModal').modal('hide');
            switch(request.status){
                case 422:
                    console.log(request);
                    console.log(error);
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

});
</script>
@endsection
