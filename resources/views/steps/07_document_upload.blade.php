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
    <input id="input-1a" type="file" class="file" data-show-preview="false">
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
</script>
@endsection
