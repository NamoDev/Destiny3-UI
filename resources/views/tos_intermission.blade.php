@extends('layouts.no_navbar')
@section('title', 'เงื่อนไขการสมัคร')

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

<div class="row" style="margin-top:30px;">
    {{-- TERMS OF SERVICE INTERMISSION HERE --}}
    <h2>เงื่อนไขการสมัคร</h2>
    <br />
    <div class="flat-well">

    </div>
    <br />
    <div class="row">
        <div class="col-xs-6">
            <a class="btn btn-info btn-block" href="/">กลับหน้าหลัก</a>
        </div>
        <div class="col-xs-6">
            <a class="btn btn-primary btn-block" href="/application/begin">ยอมรับเงื่อนไขและดำเนินการต่อ</a>
        </div>
    </div>
</div>

@endsection
@section('additional_scripts')
<script src="/assets/js/k.js"></script>
<script>
    var easter_egg = new Konami("/application/sst/VFVEVF84MA==");
</script>
@endsection
