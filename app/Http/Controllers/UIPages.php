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

class UIPages extends Controller {

    // Public homepage
    public function homePage() {
        $visitingApplicant = new Applicant();
        if ($visitingApplicant->isLoggedIn()) {
            return redirect('application/home');
        } else {
            return response()->view('login_home');
        }
    }

    // Registration homepage
    public function newUserRegistrationPage() {
        return response()->view('steps.00_new_user_registration');
    }

    // Applicant home page (a.k.a. the "Dashboard")
    public function applicantDashboard() {
        return response()->view('dashboard');
    }

    // "Change Password" page for logged in users
    public function changePasswordPage() {
        return response()->view('change_password');
    }

    // Application about page
    public function aboutPage() {
        return response()->view('about');
    }

    // Frequently asked questions
    public function faqPage() {
        return response()->view('faq');
    }

    public function unsupportedBrowser() {
        return response()->view('unsupported_browser');
    }

    public function iForgotLandingPage(){
        return response()->view('iforgot_landing');
    }

    public function iForgotSentPage(){
        return response()->view('iforgot_sent');
    }

    public function iForgotErrorPage(){
        return response()->view('iforgot_error');
    }

    public function iForgotSuccessPage(){
        return response()->view('iforgot_success');
    }

    // Step 01: Applicant's basic information
    public function step1_basicInfo() {
        $applicantData = Applicant::current();

        return response()->view('steps.01_basic_information', ['applicantData' => $applicantData]);
    }

    // Step 02: Applicant's parent information
    public function step2_parentInfo() {
        $applicantData = Applicant::current();

        return response()->view('steps.02_parent_information', ['applicantData' => $applicantData]);
    }

    // Step 03: Applicant's address
    public function step3_address() {
        $applicantData = Applicant::current();

        return response()->view('steps.03_address', ['applicantData' => $applicantData]);
    }

    // Step 04: Applicant's educational history
    public function step4_educationHistory() {
        $applicantData = Applicant::current();

        return response()->view('steps.04_education_history', ['applicantData' => $applicantData]);
    }

    // Step 05: Plan selection
    public function step5_planSelection() {
        $applicantData = Applicant::current();

        return response()->view('steps.05_plan_selection', ['applicantData' => $applicantData]);
    }

    // Step 06: Application day selection
    public function step6_applicationDaySelection() {
        $applicantData = Applicant::current();
        $applicationDays = DB::collection("application_days")->get();

        return response()->view('steps.06_application_day_selection', ['applicantData' => $applicantData, 'applicationDays' => $applicationDays]);
    }

    // Step 07: Document upload & verification
    public function step7_uploadDocuments() {
        $applicantData = Applicant::current();
        $upload_token = hash('sha256', rand().'_'.microtime().'_'.uniqid());
        Session::put('upload_token', $upload_token);
        Session::put('upload_time', time());

        return response()->view('steps.07_document_upload', ['applicantData' => $applicantData, 'upload_token' => $upload_token]);
    }

    public function step8_gradeInfo(){
        return response()->view('steps.08_quota_grade');
    }

    public function districtQuotaSubmissionConfirmation(){
        return response()->view('confirm_quota_submission');
    }
}
