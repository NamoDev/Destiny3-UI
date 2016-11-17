@extends('layouts.master')

@section('title', 'อัพโหลดเอกสารประกอบ')

@section('content')
<legend><i class="fa fa-upload"></i> อัพโหลดเอกสารประกอบ <i class="fa fa-spinner fa-spin text-muted pull-right" style="display:none;" id="loadingSpinner"></i></legend>

<div class="row">
    <div class="col-md-6">
        <b>รูปถ่าย</b> ขนาด 1.5 นิ้ว
        <form action="/api/v1/applicant/documents_upload/image" class="dropzone" id="filePicture"></form>
    </div>
    <div class="col-md-6">
        <b>บัตรประจำตัวประชาชน</b>
        <form action="/api/v1/applicant/documents_upload/citizen_card" class="dropzone" id="fileCID"></form>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-6">
        <b>ใบ ปพ.1</b> (5 ภาคเรียน)
        <form action="/api/v1/applicant/documents_upload/transcript" class="dropzone" id="fileTranscript"></form>
    </div>
    <div class="col-md-6">
        <b>สำเนาทะเบียนบ้าน</b> ของนักเรียน
        <form action="/api/v1/applicant/documents_upload/student_hr" class="dropzone" id="fileHRApplicant"></form>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-6">
        <b>สำเนาทะเบียนบ้าน</b> ของบิดา
        <form action="/api/v1/applicant/documents_upload/father_hr" class="dropzone" id="fileHRFather"></form>
    </div>
    <div class="col-md-6">
        <b>สำเนาทะเบียนบ้าน</b> ของมารดา
        <form action="/api/v1/applicant/documents_upload/mother_hr" class="dropzone" id="fileHRMother"></form>
    </div>
</div>
<br />
<div class="row">
    <div class="col-xs-6 col-md-8">
        <span id="formAlertMessage" style="display:none;"></span>
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
<script src="/assets/js/dropzone.js"></script>
<script>
Dropzone.options.filePicture = {
    maxFilesize: 5,
    maxFiles: 1,
    addRemoveLinks: true,
    dictDefaultMessage: "<small>ลากและวางไฟล์ที่นี่ หรือคลิกเพื่อเปิดกล่องเลือกไฟล์</small><small class=\"text-muted\" style=\"margin-top:-5px;display:block;\">PNG / JPG | ขนาดไฟล์สูงสุด 2 MB</small>",
    dictRemoveFile: "ลบไฟล์",
    dictFileTooBig: "ไม่สามารถอัพโหลดได้ เนื่องจากไฟล์มีขนาดใหญ่เกิน 5 MB",
    dictInvalidFileType: "ไฟล์ผิดประเภท ต้องเป็นรูปภาพ PNG หรือ JPG เท่านั้น",
    dictResponseError: "เกิดข้อผิดพลาดของเซิร์ฟเวอร์",
    dictCancelUpload: "ยกเลิกการอัพโหลด",
    dictCancelUploadConfirmation: "ยืนยันยกเลิกการอัพโหลดหรือไม่",
    maxfilesexceeded: function(file) {
        this.removeAllFiles();
        this.addFile(file);
    },
};
Dropzone.options.fileCID = {
    maxFilesize: 5,
    maxFiles: 1,
    addRemoveLinks: true,
    dictDefaultMessage: "<small>ลากและวางไฟล์ที่นี่ หรือคลิกเพื่อเปิดกล่องเลือกไฟล์</small><small class=\"text-muted\" style=\"margin-top:-5px;display:block;\">PNG / JPG | ขนาดไฟล์สูงสุด 2 MB</small>",
    dictRemoveFile: "ลบไฟล์",
    dictFileTooBig: "ไม่สามารถอัพโหลดได้ เนื่องจากไฟล์มีขนาดใหญ่เกิน 5 MB",
    dictInvalidFileType: "ไฟล์ผิดประเภท ต้องเป็นรูปภาพ PNG หรือ JPG เท่านั้น",
    dictResponseError: "เกิดข้อผิดพลาดของเซิร์ฟเวอร์",
    dictCancelUpload: "ยกเลิกการอัพโหลด",
    dictCancelUploadConfirmation: "ยืนยันยกเลิกการอัพโหลดหรือไม่",
    maxfilesexceeded: function(file) {
        this.removeAllFiles();
        this.addFile(file);
    },
};
Dropzone.options.fileTranscript = {
    maxFilesize: 5,
    maxFiles: 1,
    addRemoveLinks: true,
    dictDefaultMessage: "<small>ลากและวางไฟล์ที่นี่ หรือคลิกเพื่อเปิดกล่องเลือกไฟล์</small><small class=\"text-muted\" style=\"margin-top:-5px;display:block;\">PNG / JPG | ขนาดไฟล์สูงสุด 2 MB</small>",
    dictRemoveFile: "ลบไฟล์",
    dictFileTooBig: "ไม่สามารถอัพโหลดได้ เนื่องจากไฟล์มีขนาดใหญ่เกิน 5 MB",
    dictInvalidFileType: "ไฟล์ผิดประเภท ต้องเป็นรูปภาพ PNG หรือ JPG เท่านั้น",
    dictResponseError: "เกิดข้อผิดพลาดของเซิร์ฟเวอร์",
    dictCancelUpload: "ยกเลิกการอัพโหลด",
    dictCancelUploadConfirmation: "ยืนยันยกเลิกการอัพโหลดหรือไม่",
    maxfilesexceeded: function(file) {
        this.removeAllFiles();
        this.addFile(file);
    },
};
Dropzone.options.fileHRApplicant = {
    maxFilesize: 5,
    maxFiles: 1,
    addRemoveLinks: true,
    dictDefaultMessage: "<small>ลากและวางไฟล์ที่นี่ หรือคลิกเพื่อเปิดกล่องเลือกไฟล์</small><small class=\"text-muted\" style=\"margin-top:-5px;display:block;\">PNG / JPG | ขนาดไฟล์สูงสุด 2 MB</small>",
    dictRemoveFile: "ลบไฟล์",
    dictFileTooBig: "ไม่สามารถอัพโหลดได้ เนื่องจากไฟล์มีขนาดใหญ่เกิน 5 MB",
    dictInvalidFileType: "ไฟล์ผิดประเภท ต้องเป็นรูปภาพ PNG หรือ JPG เท่านั้น",
    dictResponseError: "เกิดข้อผิดพลาดของเซิร์ฟเวอร์",
    dictCancelUpload: "ยกเลิกการอัพโหลด",
    dictCancelUploadConfirmation: "ยืนยันยกเลิกการอัพโหลดหรือไม่",
    maxfilesexceeded: function(file) {
        this.removeAllFiles();
        this.addFile(file);
    },
};
Dropzone.options.fileHRFather = {
    maxFilesize: 5,
    maxFiles: 1,
    addRemoveLinks: true,
    dictDefaultMessage: "<small>ลากและวางไฟล์ที่นี่ หรือคลิกเพื่อเปิดกล่องเลือกไฟล์</small><small class=\"text-muted\" style=\"margin-top:-5px;display:block;\">PNG / JPG | ขนาดไฟล์สูงสุด 2 MB</small>",
    dictRemoveFile: "ลบไฟล์",
    dictFileTooBig: "ไม่สามารถอัพโหลดได้ เนื่องจากไฟล์มีขนาดใหญ่เกิน 5 MB",
    dictInvalidFileType: "ไฟล์ผิดประเภท ต้องเป็นรูปภาพ PNG หรือ JPG เท่านั้น",
    dictResponseError: "เกิดข้อผิดพลาดของเซิร์ฟเวอร์",
    dictCancelUpload: "ยกเลิกการอัพโหลด",
    dictCancelUploadConfirmation: "ยืนยันยกเลิกการอัพโหลดหรือไม่",
    maxfilesexceeded: function(file) {
        this.removeAllFiles();
        this.addFile(file);
    },
};
Dropzone.options.fileHRMother = {
    maxFilesize: 5,
    maxFiles: 1,
    addRemoveLinks: true,
    dictDefaultMessage: "<small>ลากและวางไฟล์ที่นี่ หรือคลิกเพื่อเปิดกล่องเลือกไฟล์</small><small class=\"text-muted\" style=\"margin-top:-5px;display:block;\">PNG / JPG | ขนาดไฟล์สูงสุด 2 MB</small>",
    dictRemoveFile: "ลบไฟล์",
    dictFileTooBig: "ไม่สามารถอัพโหลดได้ เนื่องจากไฟล์มีขนาดใหญ่เกิน 5 MB",
    dictInvalidFileType: "ไฟล์ผิดประเภท ต้องเป็นรูปภาพ PNG หรือ JPG เท่านั้น",
    dictResponseError: "เกิดข้อผิดพลาดของเซิร์ฟเวอร์",
    dictCancelUpload: "ยกเลิกการอัพโหลด",
    dictCancelUploadConfirmation: "ยืนยันยกเลิกการอัพโหลดหรือไม่",
    maxfilesexceeded: function(file) {
        this.removeAllFiles();
        this.addFile(file);
    },
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
