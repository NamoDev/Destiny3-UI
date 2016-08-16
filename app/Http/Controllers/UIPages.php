<?php

/*
|
| DestinyUI 3.0
| (C) 2016 TUDT
|
| UI Pages controller
|
*/

namespace App\Http\Controllers;

class UIPages extends Controller{

  // Applicant home page (a.k.a. the "Dashboard")
  public function applicantHomePage(){
    return response()->view('applicant_home');
  }

    public function homepage(){
        return response()->view('welcome');
    }

}
