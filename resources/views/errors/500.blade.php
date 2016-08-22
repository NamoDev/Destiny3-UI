@extends('layouts.no_navbar')
@section('title', '503')

@section('content')

<div class="row" style="margin-top:120px;">
    <div class="col-md-8 col-md-offset-2">
        <div class="row">
            <div class="col-sm-4">
                <img src="/assets/images/woah.png" alt="O NOES" width="200px" />
            </div>
            <div class="col-sm-8">
                <h3 style="margin-top:80px;">เกิดข้อผิดพลาดบางประการ กรุณาลองใหม่อีกครั้ง</h3>
                <br />
                <a href="/" class="btn btn-warning" target="_self">&nbsp;&nbsp;&nbsp;&nbsp;กลับไปหน้าหลัก&nbsp;&nbsp;&nbsp;&nbsp;</a>
                <br />
                <a href="#" id="btnMoreInfo" class="small text-muted">Error Information</a>
            </div>
        </div>
    </div>
</div>

<div id="errorDetailsModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        {{ $exception->getMessage() }}
      </div>
    </div>
  </div>
</div>



@endsection

@section('additional_scripts')
<script>
    $("#btnMoreInfo").click(function(e){
        e.preventDefault();
        $('#errorDetailsModal').modal('show');
    });
</script>
@endsection
