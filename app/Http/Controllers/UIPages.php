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
        return response()->view('login_home');
    }

    // Registration homepage
    public function newUserRegistrationPage(){
      return response()->view('steps.00_new_user_registration');
    }

    // Applicant home page (a.k.a. the "Dashboard")
    public function applicantHomePage(){
        return response()->view('applicant_home');
    }

    // Application about page
    public function aboutPage(){
        return response()->view('about');
    }


}
