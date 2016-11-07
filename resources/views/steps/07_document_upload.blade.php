@extends('layouts.master')

@section('title', 'อัพโหลดเอกสารประกอบ')

@section('content')
<legend><i class="fa fa-upload"></i> อัพโหลดเอกสารประกอบ <i class="fa fa-spinner fa-spin text-muted pull-right" style="display:none;" id="loadingSpinner"></i></legend>

<div class="row">
    <div class="col-md-6">
        <b>รูปถ่าย</b> ขนาด 1.5 นิ้ว
        <form action="/file-upload" class="dropzone" id="filePicture"></form>
    </div>
    <div class="col-md-6">
        <b>บัตรประจำตัวประชาชน</b>
        <form action="/file-upload" class="dropzone" id="fileCID"></form>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-6">
        <b>ใบ ปพ.1</b> (5 ภาคเรียน)
        <form action="/file-upload" class="dropzone" id="fileTranscript"></form>
    </div>
    <div class="col-md-6">
        <b>สำเนาทะเบียนบ้าน</b> ของนักเรียน
        <form action="/file-upload" class="dropzone" id="fileHRApplicant"></form>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-6">
        <b>สำเนาทะเบียนบ้าน</b> ของบิดา
        <form action="/file-upload" class="dropzone" id="fileHRFather"></form>
    </div>
    <div class="col-md-6">
        <b>สำเนาทะเบียนบ้าน</b> ของมารดา
        <form action="/file-upload" class="dropzone" id="fileHRMother"></form>
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
Dropzone.options.filePicture = {
    maxFilesize: 2,
    maxFiles: 1,
    addRemoveLinks: true,
    maxfilesexceeded: function(file) {
        this.removeAllFiles();
        this.addFile(file);
    },
    dictDefaultMessage: "<small>ลากและวางไฟล์ที่นี่ หรือคลิกเพื่อเปิดกล่องเลือกไฟล์</small><small class=\"text-muted\" style=\"margin-top:-5px;display:block;\">PNG / JPG | ขนาดไฟล์สูงสุด 2 MB</small>"
};
Dropzone.options.fileCID = {
    maxFilesize: 2,
    maxFiles: 1,
    addRemoveLinks: true,
    maxfilesexceeded: function(file) {
        this.removeAllFiles();
        this.addFile(file);
    },
    dictDefaultMessage: "<small>ลากและวางไฟล์ที่นี่ หรือคลิกเพื่อเปิดกล่องเลือกไฟล์</small><small class=\"text-muted\" style=\"margin-top:-5px;display:block;\">PNG / JPG | ขนาดไฟล์สูงสุด 2 MB</small>"
};
Dropzone.options.fileTranscript = {
    maxFilesize: 2,
    maxFiles: 1,
    addRemoveLinks: true,
    maxfilesexceeded: function(file) {
        this.removeAllFiles();
        this.addFile(file);
    },
    dictDefaultMessage: "<small>ลากและวางไฟล์ที่นี่ หรือคลิกเพื่อเปิดกล่องเลือกไฟล์</small><small class=\"text-muted\" style=\"margin-top:-5px;display:block;\">PNG / JPG | ขนาดไฟล์สูงสุด 2 MB</small>"
};
Dropzone.options.fileHRApplicant = {
    maxFilesize: 2,
    maxFiles: 1,
    addRemoveLinks: true,
    maxfilesexceeded: function(file) {
        this.removeAllFiles();
        this.addFile(file);
    },
    dictDefaultMessage: "<small>ลากและวางไฟล์ที่นี่ หรือคลิกเพื่อเปิดกล่องเลือกไฟล์</small><small class=\"text-muted\" style=\"margin-top:-5px;display:block;\">PNG / JPG | ขนาดไฟล์สูงสุด 2 MB</small>"
};
Dropzone.options.fileHRFather = {
    maxFilesize: 2,
    maxFiles: 1,
    addRemoveLinks: true,
    maxfilesexceeded: function(file) {
        this.removeAllFiles();
        this.addFile(file);
    },
    dictDefaultMessage: "<small>ลากและวางไฟล์ที่นี่ หรือคลิกเพื่อเปิดกล่องเลือกไฟล์</small><small class=\"text-muted\" style=\"margin-top:-5px;display:block;\">PNG / JPG | ขนาดไฟล์สูงสุด 2 MB</small>"
};
Dropzone.options.fileHRMother = {
    maxFilesize: 2,
    maxFiles: 1,
    addRemoveLinks: true,
    maxfilesexceeded: function(file) {
        this.removeAllFiles();
        this.addFile(file);
    },
    dictDefaultMessage: "<small>ลากและวางไฟล์ที่นี่ หรือคลิกเพื่อเปิดกล่องเลือกไฟล์</small><small class=\"text-muted\" style=\"margin-top:-5px;display:block;\">PNG / JPG | ขนาดไฟล์สูงสุด 2 MB</small>"
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
