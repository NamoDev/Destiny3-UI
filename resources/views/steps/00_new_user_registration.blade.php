@extends('layouts.no_navbar')
@section('title', 'สมัครใหม่')


@section('content')
<div class="row" style="margin-top:80px;">
    <div class="col-md-12">
        <h2>สมัครใหม่</h2>
        <br />
        <div class="flat-well">
          <div class="row">
            <div class="col-md-2 col-xs-4">
              <select id="title" name="title" class="form-control select select-primary select-block mbl">
                <optgroup label="คำนำหน้าชื่อ">
                  <option value="0">ด.ช.</option>
                  <option value="1">ด.ญ.</option>
                  <option value="2">นาย</option>
                  <option value="3">นางสาว</option>
                  <option value="4">อื่นๆ</option>
                </optgroup>
              </select>
            </div>
            <div class="col-md-4 col-md-offset-1 col-xs-8">
              <input id="fname" name="fname" type="text" placeholder="ชื่อ" class="form-control" />
            </div>
            <div class="col-md-5 col-xs-12">
              <input id="lname" name="lname" type="text" placeholder="นามสกุล" class="form-control" />
            </div>
          </div>
          <!-- == --><br />
          <div class="row">
            <div class="col-md-2 col-xs-4">
              <!-- Hidden: english title text. Box here will appear only if the title is selected as "other" -->
            </div>
            <div class="col-md-4 col-md-offset-1 col-xs-8">
              <input id="fname_en" name="fname_en" type="text" placeholder="First name" class="form-control" />
            </div>
            <div class="col-md-5 col-xs-12">
              <input id="lname_en" name="lname_en" type="text" placeholder="Last name" class="form-control" />
            </div>
          </div>
        </div>
    </div>
</div>
@endsection

@section('additional_scripts')
<script>
$(function(){
  $("select").select2({dropdownCssClass: 'dropdown-inverse'});
})
</script>
@endsection
