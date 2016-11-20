<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
Publicly accessible routes (a.k.a. Root Routes)
NOTE: For some weird reason, putting these routes in a group results in session flash not working. Further experimentation required.
*/
Route::get('/', 'UIPages@homePage'); // DAT HOMEPAGE
Route::post('login', 'UserController@login'); // Login request handler
Route::get('logout', 'UserController@logout'); // Logout request handler
Route::get('about', 'UIPages@aboutPage'); // About application
Route::get('faq', 'UIPages@faqPage'); // FAQ
Route::get('bad_browser', 'UIPages@unsupportedBrowser'); // Unsupported browser
Route::get('application/begin', 'UIPages@newUserRegistrationPage'); // New account creation

Route::get('iforgot', 'UIPages@iForgotLandingPage'); // Password reset landing page
Route::get('iforgot/done', 'UIPages@iForgotSentPage'); // Password reset "sent" page
Route::get('iforgot/error', 'UIPages@iForgotErrorPage'); // Password reset error page
Route::get('iforgot/link/{token}', 'UserController@handleiForgotLink'); // Password reset link handler page
Route::get('iforgot/success', 'UIPages@iForgotSuccessPage'); // Password reset "sent" page

Route::any('application/sst/VFVEVF84MA==', 'UserController@ganymede'); // Easter egg route. DON'T TOUCH!

Route::group(['middleware' => ['web']], function () {
    Route::get('support', 'Andromeda@helpme');
});

/*
Front-end pages for logged in applicants
*/
Route::group(['prefix' => 'application', 'middleware' => ['web', 'auth', 'flow']], function () {

    Route::get('home', 'UIPages@applicantDashboard'); // Dashboard
    Route::get('info', 'UIPages@step1_basicInfo'); // Step 1 : basic information
    Route::get('parent', 'UIPages@step2_parentInfo'); // Step 2 : parent information
    Route::get('address', 'UIPages@step3_address'); // Step 3 : address
    Route::get('education', 'UIPages@step4_educationHistory'); // Step 4 : education history
    Route::get('plan', 'UIPages@step5_planSelection'); // Step 5 : basic information
    Route::get('day', 'UIPages@step6_applicationDaySelection'); // Step 6 : basic information
    Route::get('documents', 'UIPages@step7_uploadDocuments'); // Step 7 : upload documents
    Route::get('change_password', 'UIPages@changePasswordPage'); // Change password
    Route::get('grade', 'UIPages@step8_gradeInfo'); // Step 8 : Grade form for province quota
});

// Account creation API route. Not in the API group cause we can't use apiauth middleware there
Route::post('api/v1/account/create', 'UserController@createAccount');

// iForgot handlers
Route::post('api/v1/iforgot/submit', 'UserController@handleiForgotRequest');
Route::post('api/v1/iforgot/request', 'UserController@handleiForgotForm');

/*
| API Routes (v1)
*/
Route::group(['prefix' => 'api/v1', 'middleware' => ['apiauth']], function () {

    // Get applicant data. Simple!
    Route::get('applicant/data', 'UserController@getApplicantData');

    // Applicant's basic data submission
    Route::post('applicant/data', 'UserController@updateApplicantData');

    // Parent/guardian information submission
    Route::post('applicant/parent_info', 'UserController@updateParentInformation');

    Route::post('applicant/address', 'UserController@updateAddressInfo');

    // Education history (profile) submission
    Route::post('applicant/education_history', 'UserController@updateEducationInformation');

    // Education history (profile) submission
    Route::post('applicant/plan_selection', 'UserController@updatePlanSelectionInformation');

    // Application day selection
    Route::post('applicant/application_day', 'UserController@updateApplicationDaySelection');

    // Documents submission
    Route::post('applicant/documents_upload/{name}', 'UserController@handleDocuments');
    Route::post('applicant/documents_confirm', 'UserController@confirmDocument');

    Route::post('applicant/grade', 'UserController@updateGradeInfo');

    // Submit complete data & get PDF. Using GET here 'cause the client will directly access this URL.
    Route::get('applicant/submit', 'Blah@Blah');

    // Password change handler
    Route::post('account/change_password', 'UserController@changePassword');

    // Get document for a student (by CID)
    Route::get('documents/{citizen_id}/{filename?}', 'UserController@getDocument');

});
