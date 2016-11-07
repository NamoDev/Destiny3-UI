@extends('layouts.master')

@section('title', 'อัพโหลดเอกสารประกอบ')

@section('content')
<legend><i class="fa fa-upload"></i> อัพโหลดเอกสารประกอบ <i class="fa fa-spinner fa-spin text-muted pull-right" style="display:none;" id="loadingSpinner"></i></legend>

<div class="row">
    <div class="col-md-6">
        <form action="/file-upload" class="dropzone" id="file_picture"></form>
    </div>
    <div class="col-md-6">
        <form action="/file-upload" class="dropzone" id="file_form1"></form>
    </div>
</div>

<div class="row">
    <label class="control-label">Select File</label>
    <input id="transcript" type="file" class="file" data-show-preview="false">
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
<<<<<<< HEAD
<script src="/assets/js/dropzone.js"></script>
<script>
Dropzone.options.file_picture = {
  maxFilesize: 2, // MB
  maxFiles: 1,
  addRemoveLinks: true
};
=======
<script>
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
>>>>>>> fba2706e22d61e2312f466482be9b2be5716c414
</script>
@endsection
