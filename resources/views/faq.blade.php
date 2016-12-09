@extends('layouts.no_navbar')
@section('title', 'คำถามที่พบบ่อย')

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
    <div class="col-md-12">
        <h3>คำถามที่พบบ่อย</h3>
    </div>
</div>

<div class="row" style="margin-top:18px;">
    <div class="col-md-12">
        <div class="flat-well">
            <ul>
              <li><strong>จำเป็นต้องอัพโหลดเอกสารชนิดหนึ่งมากกว่า 1 หน้า ต้องทำอย่างไร</strong>  เนื่องจากระบบออกแบบมาให้รับได้เพียง 1 ไฟล์ต่อประเภทเอกสาร ดังนั้น ให้นักเรียนต่อภาพเข้าด้วยกันเป็นภาพเดียว</li>
              <li><strong>ต้องใช้ไฟล์ความละเอียดเท่าใด สามารถใช้กล้องถ่ายรูปแทนเครื่องสแกนได้หรือไม่</strong>  ให้นักเรียนอัพโหลดไฟล์ภาพที่สามารถมองเห็นตัวอักษรหรือรายละเอียดได้ชัดเจนทั้งหมด</li>
              <li><strong>ใบรับรองผลการเรียนคืออะไร</strong>  ใบรับรองผลการเรียนเฉลี่ยรายวิชา เป็นเอกสารที่โรงเรียนปัจจุบันของนักเรียนจะรับรองการคำนวณผลการเรียนเฉลี่ยรายวิชาให้กับนักเรียน โดยนักเรียนสามารถพิมพ์แบบฟอร์มได้จากหน้าแรกของระบบฯ</li>
            </ul>
        </div>
    </div>
    <br />
</div>

<div class="row" style="margin-top:15px;">
    <div class="col-md-12">
        <a href="/" class="btn btn-lg btn-block btn-primary">กลับหน้าหลัก</a>
    </div>
</div>

@endsection
