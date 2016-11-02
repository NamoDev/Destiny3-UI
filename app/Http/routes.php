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
Route::get('bad_browser', 'UIPages@unsupportedBrowser');
Route::get('application/begin', 'UIPages@newUserRegistrationPage'); // New account creation
Route::any('application/sst/VFVEVF84MA==', 'UserController@ganymede'); // Easter egg route. DON'T TOUCH!

/*
Front-end pages for logged in applicants
*/
Route::group(['prefix' => 'application', 'middleware' => ['web', 'auth']], function () {

	Route::get('home', 'UIPages@applicantDashboard'); // Dashboard
	Route::get('info', 'UIPages@step1_basicInfo'); // Step 1 : basic information
	Route::get('parent', 'UIPages@step2_parentInfo'); // Step 2 : parent information
	Route::get('address', 'UIPages@step3_address'); // Step 3 : address
	Route::get('education', 'UIPages@step4_educationHistory'); // Step 4 : education history
	Route::get('plan', 'UIPages@step5_planSelection'); // Step 5 : basic information
	Route::get('day', 'UIPages@step6_applicationDaySelection'); // Step 6 : basic information
	Route::get('documents', 'UIPages@step7_uploadDocuments'); // Step 7 : upload documents
	Route::get('change_password', 'UIPages@changePasswordPage'); // Change password

});

/*
| API Routes (v1)
*/
Route::group(['prefix' => 'api/v1', 'middleware' => ['web']], function(){

    /*
    NOTE: These routes won't work yet - there's no backend handler for it!
    This is just for planning purposes.
    */

    // Account creation
    Route::post('account/create', 'UserController@createAccount');

    // TODO: Add API authentication middlewares for API routes below:

    // Get applicant data. Simple!
    Route::get('applicant/data', 'UserController@getApplicantData')->middleware('apiauth');

    // Applicant's basic data submission
    Route::post('applicant/data', 'UserController@updateApplicantData')->middleware('apiauth');

    // Parent/guardian information submission
    Route::post('applicant/parent_info', 'UserController@updateParentInformation')->middleware('apiauth');

	// Education history (profile) submission
	Route::post('applicant/education_history', 'UserController@updateEducationInformation')->middleware('apiauth');

    // Submit complete data & get PDF. Using GET here 'cause the client will directly access this URL.
    Route::get('applicant/submit', 'Blah@Blah')->middleware('apiauth');

    // Password change handler
    Route::post('account/change_password', 'UserController@changePassword')->middleware('apiauth');


});
