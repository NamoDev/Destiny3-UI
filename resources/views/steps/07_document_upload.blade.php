@extends('layouts.master')

@section('title', 'อัพโหลดเอกสารประกอบ')

@section('content')
<legend><i class="fa fa-upload"></i> อัพโหลดเอกสารประกอบ <i class="fa fa-spinner fa-spin text-muted pull-right" style="display:none;" id="loadingSpinner"></i></legend>
<div class="row">
    <label class="control-label">Select File</label>
    <input id="input-1a" type="file" class="file" data-show-preview="false">
</div>
@endsection

@section('additional_scripts')

@endsection
