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

use Applicant;
use DB;
use Session;

class UIPages extends Controller{

    // Public homepage
    public function homePage(){
      $visitingApplicant = new Applicant();
      if($visitingApplicant->isLoggedIn()){
        return redirect('application/home');
      }else{
        return response()->view('login_home');
      }
    }

    // Registration homepage
    public function newUserRegistrationPage(){
      return response()->view('steps.00_new_user_registration');
    }

    // Applicant home page (a.k.a. the "Dashboard")
    public function applicantDashboard(){
        return response()->view('dashboard');
    }

    // "Change Password" page for logged in users
    public function changePasswordPage(){
        return response()->view('change_password');
    }

    // Application about page
    public function aboutPage(){
        return response()->view('about');
    }

    // Frequently asked questions
    public function faqPage(){
        return response()->view('faq');
    }

    public function unsupportedBrowser(){
        return response()->view('unsupported_browser');
    }

    // Step 01: Applicant's basic information
    public function step1_basicInfo(){
        $applicantData = DB::collection("applicants")->where("citizenid", Session::get("applicant_citizen_id"))->first();
        return response()->view('steps.01_basic_information', ['applicantData' => $applicantData]);
    }

    // Step 02: Applicant's parent information
    public function step2_parentInfo(){
        $applicantData = DB::collection("applicants")->where("citizenid", Session::get("applicant_citizen_id"))->first();
        return response()->view('steps.02_parent_information', ['applicantData' => $applicantData]);
    }

    // Step 03: Applicant's address
    public function step3_address(){
        $applicantData = DB::collection("applicants")->where("citizenid", Session::get("applicant_citizen_id"))->first();
        return response()->view('steps.03_address', ['applicantData' => $applicantData]);
    }

    // Step 04: Applicant's educational history
    public function step4_educationHistory(){
        $applicantData = DB::collection("applicants")->where("citizenid", Session::get("applicant_citizen_id"))->first();
        return response()->view('steps.04_education_history', ['applicantData' => $applicantData]);
    }

    // Step 05: Plan selection
    public function step5_planSelection(){
        $applicantData = DB::collection("applicants")->where("citizenid", Session::get("applicant_citizen_id"))->first();
        return response()->view('steps.05_plan_selection', ['applicantData' => $applicantData]);
    }

    // Step 06: Application day selection
    public function step6_applicationDaySelection(){
        $applicantData = DB::collection("applicants")->where("citizenid", Session::get("applicant_citizen_id"))->first();
        return response()->view('steps.06_application_day_selection', ['applicantData' => $applicantData]);
    }

    // Step 07: Document upload & verification
    public function step7_uploadDocuments(){
        $applicantData = DB::collection("applicants")->where("citizenid", Session::get("applicant_citizen_id"))->first();
        return response()->view('steps.07_document_upload', ['applicantData' => $applicantData]);
    }





}
