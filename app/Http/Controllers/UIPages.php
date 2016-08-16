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

    // Public homepage
    public function homePage(){
        return response()->view('welcome');
    }

    // Applicant home page (a.k.a. the "Dashboard")
    public function applicantHomePage(){
        return response()->view('applicant_home');
    }



}
