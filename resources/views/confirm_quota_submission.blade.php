@extends('layouts.no_navbar')
@section('title', 'หน้าหลัก')

@section('content')
<!--
  ________  ______  ______
 /_  __/ / / / __ \/_  __/
  / / / / / / / / / / /
 / / / /_/ / /_/ / / /
/_/  \____/_____/ /_/

TUEnt "Destiny", (C) {{ date("Y") }} TUDT.

The world could always use more developers. Are you with us?
https://tucc.triamudom.ac.th

-->

<div class="row" style="margin-top:100px;">
    <div class="col-xs-12 col-md-10 col-md-offset-1">
        <div class="well">
            <h3>ยืนยันการส่งข้อมูล <i class="fa fa-question-circle"></i></h3>
            <b>โปรดทราบ:</b> เมื่อนักเรียนทำการส่งข้อมูลแล้ว จะไม่สามารถกลับมาแก้ไขข้อมูลได้อีก จนกว่าโรงเรียนเตรียมอุดมศึกษาจะทำการตรวจสอบเอกสารของนักเรียนเป็นที่เรียบร้อย <br />

            <br />
            <div class="row">
                <div class="col-xs-12">
                    <label class="checkbox"><input type="checkbox" id="confirm_send" name="confirm_send"> นักเรียนได้อ่านและเข้าใจคำแนะนำแล้ว</label>
                    <span class="help-block" id="confirmAlertText" style="display:none;"><i class="fa fa-exclamation-circle"></i> กรุณาทำเครื่องหมายถูกในช่องนี้ก่อน</span>
                </div>
            </div>
            <span class="help-block" id="errorText" style="display:none;"><br /><i class="fa fa-exclamation-circle"></i> เกิดข้อผิดพลาดของระบบ กรุณาลองใหม่อีกครั้งภายหลัง</span>
            <br />
            <div class="row">
                <div class="col-xs-6">
                    <a class="btn btn-block btn-primary" href="/application/home">กลับไปแก้ไขข้อมูล</a>
                </div>
                <div class="col-xs-6">
                    <a class="btn btn-block btn-inverse disabled" href="#" id="btnSend">ยืนยันการส่งข้อมูล</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="plsWaitModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <i class="fa fa-spinner fa-spin"></i> กรุณารอสักครู่
      </div>
    </div>
  </div>
</div>

@endsection

@section('additional_scripts')
<script>
    $(function(){
        $(':checkbox').radiocheck();
    });
    $('#confirm_send').on('change',function(){
        if($("#confirm_send").is(":checked")){
            $("#btnSend").removeClass("disabled");
        }else{
            $("#btnSend").addClass("disabled");
        }
    });

    $("#btnSend").click(function(e){
        e.preventDefault();
        if($("#confirm_send").is(":checked")){
            $("#confirmAlertText").fadeOut(200);
            $("#errorText").fadeOut(200);
            $('#plsWaitModal').modal('show');
            $.ajax({
                url: '/api/v1/applicant/submit_quota',
                data: {
                    _token: csrfToken,
                },
                error: function (request, status, error) {
                    $('#plsWaitModal').modal('hide');
                    switch(request.status){
                        case 422:
                            console.log(request);
                            console.log(error);
                            $("#errorText").fadeIn(200);
                        break;
                        default:
                            console.log("(" + request.status + ") Exception:" + request.responseText);
                            $("#errorText").fadeIn(200);
                    }
                },
                dataType: 'json',
                success: function(data) {
                    $('#plsWaitModal').modal('hide');
                    window.location.replace("/application/home");
                },
                type: 'POST'
            });
        }else{
            $("#confirmAlertText").fadeIn(200);
        }
    });

</script>
@endsection
