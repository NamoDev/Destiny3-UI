<?php

/*
|
| DestinyUI 3.0
| (C) 2016 TUDT
|
| API endpoints controller
|
*/

namespace App\Http\Controllers;

use Applicant;
use Exception;
use Illuminate\Http\Request;
use Log;
use DB;
use Session;
use Hash;
use Response;
use Redirect;
use Storage;
use RESTResponse;
use Config;
use Base64Exception;
use Mail;
use Validator;
use App\Requirement;

class UserController extends Controller{

    // TODO: Better comments & standardized method commenting!

    /*
    | Account creation API endpoint
    */
    public function createAccount(Request $request){

        // Applicant object
        $applicantObject = new Applicant();

        // Store errors, we'll send the client these:
        $errors = [];

        // Validate incoming data:
        $this->validate($request, [
            'customtitle' => 'required',
            'title' => 'required',
            'fname' => 'required',
            'lname' => 'required',
            'title_en' => 'required',
            'fname_en' => 'required',
            'lname_en' => 'required',
            'gender' => 'required',
            'citizenid' => 'required',
            'birthdate' => 'required|integer',
            'birthmonth' => 'required|integer',
            'birthyear' => 'required|integer',
            'email' => 'required|email',
            'phone' => 'required',
            'password' => 'required|same:password_confirm',
            'password_confirm' => 'required|same:password',
            'recaptcha' => 'required|captcha',
        ]);

        // TODO: Make Citizen ID verification a part of the validator itself

        // Validate citizen ID
        if(!$this->verifyNationalID($request->input("citizenid"))){
            // Citizen ID error
            $errors[] = "citizenid";
        }


        // See if the user has already registered?
        if($applicantObject->exists($request->input("citizenid"))){
            // Already registered. Return conflict (409)!
            $errors[] = "already_registered";
            return RESTResponse::makeErrorResponse(409, $errors);
        }

        // If there are errors, notify the frontend and stop right there.
        if(count($errors) != 0){
            // O NOES, THERE ARE ERRORS!
            return RESTResponse::makeErrorResponse(417, $errors);
        }else{

            // A-OK. We can continue.
            // Format gender data
            $genderToUse = $this->formatGender($request->customtitle, $request->title, $request->gender);

            // Create user and login!
            $applicantObject->create(
                $request->input('citizenid'),
                $request->input('title'),
                $request->input('fname'),
                $request->input('lname'),
                $request->input('title_en'),
                $request->input('fname_en'),
                $request->input('lname_en'),
                $genderToUse,
                $request->input('email'),
                $request->input('phone'),
                $request->input('birthdate'),
                $request->input('birthmonth'),
                $request->input('birthyear'),
                $request->input('password')
            );

            // Log the user in
            $applicantObject->login($request->input('citizenid'), $request->input('password'));

            // return success
            return RESTResponse::ok();

        }

    }

    /*
    | Login
    */
    public function login(Request $request){
      $applicantInterface = new Applicant();
      try{
        if($applicantInterface->login($request->login_name, $request->login_password)){
          return redirect('application/home');
        }else{
          return redirect('/')->with('message', 'INVALID_USERNAME_OR_PASSWORD')->with('alert-class', 'alert-warning');
        }
      }catch(\Throwable $whatever){
        Log::error("Login exception\n" . $whatever);
        return redirect('/')->with('message', 'LOGIN_EXCEPTION_THROWN')->with('alert-class', 'alert-warning');
      }

    }

    /*
    | Logout. Simple!
    */
    public function logout(){
      $applicantInterface = new Applicant();
      $applicantInterface->logout();
      return redirect("/");
    }

    /*
    | Change password
    */
    public function changePassword(Request $request){
        /*
        old_password
        password
        password_confirm
        */

        // First, let's validate the incoming data:
        $this->validate($request, [
          'old_password' => 'required',
          'password' => 'required',
          'password_confirm' => 'required|same:password'
        ]);

        // Check the old password
        $applicantData = DB::collection("applicants")->where("citizen_id", Session::get("applicant_citizen_id"))->first();
        if(Hash::check($request->input("old_password"), $applicantData['password'])){

            // OK
            DB::collection("applicants")->where("citizen_id", Session::get("applicant_citizen_id"))->update([
                'password' => Hash::make($request->input("password")),
            ]);

            return RESTResponse::ok();

        }else{
            // Old password incorrect
            return RESTResponse::notAuthenticated('old_password_incorrect');
        }

    }

    /*
    | Modify basic applicant info (steps 0/1)
    */
    public function updateApplicantData(Request $request){

        // Get applicant object & current applicant's Citizen ID:
        $applicant = new Applicant();
        $applicantCitizenID = Session::get("applicant_citizen_id");

        // Validate incoming data
        $this->validate($request, [
            'customtitle' => 'required',
            'title' => 'required',
            'fname' => 'required',
            'lname' => 'required',
            'title_en' => 'required',
            'fname_en' => 'required',
            'lname_en' => 'required',
            'gender' => 'required',
            'birthdate' => 'required|integer',
            'birthmonth' => 'required|integer',
            'birthyear' => 'required|integer',
            'email' => 'required|email',
            'phone' => 'required'
         ]);

         // Format gender data
         $genderToUse = $this->formatGender($request->customtitle, $request->title, $request->gender);

         // Prepare our 'to-be-modified' array:
         $modifyThis = [
             'title' => $request->input("title"),
             'fname' => $request->input("fname"),
             'lname' => $request->input("lname"),
             'title_en' => $request->input("title_en"),
             'fname_en' => $request->input("fname_en"),
             'lname_en' => $request->input("lname_en"),
             'gender' => $request->input("gender"),
             'email' => $request->input("email"),
             'phone' => $request->input("phone"),
             'birthdate' => [
                 "day" => $request->input("birthdate"),
                 "month" => $request->input("birthmonth"),
                 "year" => $request->input("birthyear")
             ]
         ];

        // Modify the applicant
        if($applicant->modify($applicantCitizenID, $modifyThis)){

            // Modification went well. Let's reload the session data in case the applicant changes his/her name:
            $applicant->reloadSessionData();

            return RESTResponse::ok();
        }else{
            // error!
            return RESTResponse::serverError('Unable to modify applicant data');
        }

    }

    /*
    | Update parent information
    */
    public function updateParentInformation(Request $request){
        // Get applicant object & current applicant's Citizen ID:
        $applicant = new Applicant();
        $applicantCitizenID = Session::get("applicant_citizen_id");

        // Validate incoming data. (TODO: Come up with a better way to detect whether we need to verify guardian info as well)
        $this->validate($request, [
            'father_title' => 'required',
            'father_fname' => 'required',
            'father_lname' => 'required',
            'father_phone' => 'required_unless:father_dead,1',
            'father_occupation' => 'required_unless:father_dead,1',
            'father_dead' => 'required|integer',
            'mother_title' => 'required',
            'mother_fname' => 'required',
            'mother_lname' => 'required',
            'mother_phone' => 'required_unless:mother_dead,1',
            'mother_occupation' => 'required_unless:mother_dead,1',
            'mother_dead' => 'required|integer',
            'has_guardian' => 'required',
            'staying_with' => 'required|integer',
            'guardian_title' => 'required_if:has_guardian,1',
            'guardian_fname' => 'required_if:has_guardian,1',
            'guardian_lname' => 'required_if:has_guardian,1',
            'guardian_phone' => 'required_if:has_guardian,1',
            'guardian_occupation' => 'required_if:has_guardian,1',
            'guardian_relation' => 'required_if:has_guardian,1'
         ]);

         // Prepare our 'to-be-modified' array:
         $modifyThis = [
            'staying_with_parent' => $request->input("staying_with"),
            'father' => [
                "title" => $request->input("father_title"),
                "fname" => $request->input("father_fname"),
                "lname" => $request->input("father_lname"),
                "phone" => $request->input("father_phone"),
                "occupation" => $request->input("father_occupation"),
                "dead" => $request->input("father_dead")
            ],
            'mother' => [
                "title" => $request->input("mother_title"),
                "fname" => $request->input("mother_fname"),
                "lname" => $request->input("mother_lname"),
                "phone" => $request->input("mother_phone"),
                "occupation" => $request->input("mother_occupation"),
                "dead" => $request->input("mother_dead")
            ]
         ];

         // Only add guardian information if the applicant has a guardian:
         // TODO: Delete guardian tree if applicant has no active guardian on profile.
         if($request->input("has_guardian") == 1){
            $modifyThis['guardian'] = [
                "title" => $request->input("guardian_title"),
                "fname" => $request->input("guardian_fname"),
                "lname" => $request->input("guardian_lname"),
                "phone" => $request->input("guardian_phone"),
                "occupation" => $request->input("guardian_occupation"),
                "relation" => $request->input("guardian_relation")
            ];
        }else{
            $modifyThis['guardian'] = [];
        }

        // Modify the applicant
        if($applicant->modify($applicantCitizenID, $modifyThis)){

            // Mark step as done
            $applicant->markStepAsDone($applicantCitizenID, 2);

            return RESTResponse::ok();
        }else{
            // error!
            return RESTResponse::serverError('Unable to modify applicant data');
        }

    }

    public function updateAddressInfo(Request $request){
        // Get applicant object & current applicant's Citizen ID:
        $applicant = new Applicant();
        $applicantCitizenID = Session::get("applicant_citizen_id");

        // Validate incoming data
        $this->validate($request, [
            'home_address' => 'required',
            'home_moo' => 'required',
            'home_soi' => 'required',
            'home_road' => 'required',
            'home_subdistrict' => 'required',
            'home_district' => 'required',
            'home_province' => 'required',
            'home_postcode' => 'required',
            'current_address_same_as_home' => 'required|boolean',
            'current_address' => 'required_unless:current_address_same_as_home,1',
            'current_moo' => 'required_unless:current_address_same_as_home,1',
            'current_soi' => 'required_unless:current_address_same_as_home,1',
            'current_road' => 'required_unless:current_address_same_as_home,1',
            'current_subdistrict' => 'required_unless:current_address_same_as_home,1',
            'current_district' => 'required_unless:current_address_same_as_home,1',
            'current_province' => 'required_unless:current_address_same_as_home,1',
            'current_postcode' => 'required_unless:current_address_same_as_home,1',
        ]);

        if($request->input('current_address_same_as_home') == '1'){
            $modifyThis = [
                'address' => [
                    'current_address_same_as_home' => $request->input('current_address_same_as_home'),
                    'home' => [
                        'home_address' => $request->input('home_address'),
                        'home_moo' => $request->input('home_moo'),
                        'home_soi' => $request->input('home_soi'),
                        'home_road' => $request->input('home_road'),
                        'home_subdistrict' => $request->input('home_subdistrict'),
                        'home_district' => $request->input('home_district'),
                        'home_province' => $request->input('home_province'),
                        'home_postcode' => $request->input('home_postcode'),
                    ],
                    'current' => [
                        'current_address' => $request->input('home_address'),
                        'current_moo' => $request->input('home_moo'),
                        'current_soi' => $request->input('home_soi'),
                        'current_road' => $request->input('home_road'),
                        'current_subdistrict' => $request->input('home_subdistrict'),
                        'current_district' => $request->input('home_district'),
                        'current_province' => $request->input('home_province'),
                        'current_postcode' => $request->input('home_postcode'),
                    ],
                ],
            ];
        }else{
            $modifyThis = [
                'address' => [
                    'current_address_same_as_home' => $request->input('current_address_same_as_home'),
                    'home' => [
                        'home_address' => $request->input('home_address'),
                        'home_moo' => $request->input('home_moo'),
                        'home_soi' => $request->input('home_soi'),
                        'home_road' => $request->input('home_road'),
                        'home_subdistrict' => $request->input('home_subdistrict'),
                        'home_district' => $request->input('home_district'),
                        'home_province' => $request->input('home_province'),
                        'home_postcode' => $request->input('home_postcode'),
                    ],
                    'current' => [
                        'current_address' => $request->input('current_address'),
                        'current_moo' => $request->input('current_moo'),
                        'current_soi' => $request->input('current_soi'),
                        'current_road' => $request->input('current_road'),
                        'current_subdistrict' => $request->input('current_subdistrict'),
                        'current_district' => $request->input('current_district'),
                        'current_province' => $request->input('current_province'),
                        'current_postcode' => $request->input('current_postcode'),
                    ],
                ],
            ];
        }

        if(config('uiconfig.mode') == 'province_quota'){
            // Additional validation for province_quota
            $this->validate($request, [
                'home_move_in_day' => 'required|integer|min:1|max:31',
                'home_move_in_month' => 'required|integer|min:1|max:12',
                'home_move_in_year' => 'required|integer|max:'.config('uiconfig.operation_year'),
            ]);

            $modifyThis['address']['home_move_in_day'] = $request->input('home_move_in_day');
            $modifyThis['address']['home_move_in_month'] = $request->input('home_move_in_month');
            $modifyThis['address']['home_move_in_year'] = $request->input('home_move_in_year');
        }

        // Modify the applicant
        if($applicant->modify($applicantCitizenID, $modifyThis)){

            // Mark step as done
            $applicant->markStepAsDone($applicantCitizenID, 3);

            return RESTResponse::ok();
        }else{
            // error!
            return RESTResponse::serverError('Unable to modify applicant data');
        }

    }

    public function getDocument(Request $request, $citizen_id, $filename = null){
        if(is_null($filename)){
            // Retrieve all file
            $data = DB::collection('applicants')
            ->where('citizen_id', $citizen_id)
            ->pluck('documents.'.$request->input('timestamp'))[0];
        }else{
            $data = DB::collection('applicants')
            ->where('citizen_id', $citizen_id)
            ->pluck('documents.'.$request->input('timestamp').'.'.$filename)[0];
        }

        if(count($data) == 0){
            return RESTResponse::notFound('No data for citizen_id : ' . $citizen_id);
        }

        /*if(!$this->ipInRange($request->ip(), $range)){
            return RESTResponse::notAuthorized('IP not in permitted range');
        }*/

        if(!$request->has('token')){
            return RESTResponse::badRequest('Request does not include access key');
        }

        $token = DB::collection('applicants')
                    ->where('citizen_id', $citizen_id)
                    ->pluck('documents.'.$request->input('timestamp').'.access_token')[0];

        if($request->input('token') != $token){
            return RESTResponse::badRequest('Invalid access token');
        }

        if(is_null($filename)){
            $keys = array_keys($data);
            $i = 0;
            unset($data['access_token']);
            foreach($data as $doc){
                $encoded = base64_encode(Storage::disk('document')->get($doc['file_name']));
                if($encoded === false){
                    throw new Base64Exception('Cannot encode image file');
                }else{
                    $documents[$keys[$i]] = $encoded;
                }
                $i++;
            }
            unset($i);
        }else{
            $encoded = base64_encode(Storage::disk('document')->get($data['file_name']));
            if($encoded === false){
                throw new Base64Exception('Cannot encode image file');
            }else{
                $documents[$filename] = $encoded;
            }
        }

        return RESTResponse::makeDataResponse(200, $documents);
    }

    /*
    | Update education history information
    */
    public function updateEducationInformation(Request $request){
        // Get applicant object & current applicant's Citizen ID:
        $applicant = new Applicant();
        $applicantCitizenID = Session::get("applicant_citizen_id");
        $isESAQuotaMode = 0;

        // See if we're in ESA quota, and choose validation rules as necessary:
        if(Config::get("uiconfig.mode") == "province_quota"){
            // ESA district quota operation mode
            $isESAQuotaMode = 1;

            // TODO: Do we need to specify minimum GPA?
            $this->validate($request, [
                'school' => 'required',
                //'graduation_year' => 'required|integer',
                'gpa' => 'required|numeric|max:4.00|regex:/[1-4].[0-9]{2}/',
                'school_move_in_day' => 'required|integer',
                'school_move_in_month' => 'required|integer',
                'school_move_in_year' => 'required|integer',
                'school_province' => 'required',
             ]);
        }else{
            // Normal operation mode
            $this->validate($request, [
                'school' => 'required',
                'graduation_year' => 'required|integer',
                'gpa' => 'required|numeric|max:4.00|regex:/[1-4].[0-9]{2}/',
             ]);
        }

        // Prepare data for modification:
        $modifyThis = [
            "school" => $request->input("school"),
            "graduation_year" => $request->input("graduation_year"),
            "gpa" => $request->input("gpa")
        ];

        // Quota mode. Additional information needed:
        if($isESAQuotaMode === 1){
            $modifyThis["school_move_in"] = [
                "day" => $request->input("school_move_in_day"),
                "month" => $request->input("school_move_in_month"),
                "year" => $request->input("school_move_in_year"),
            ];
            $modifyThis["school_province"] = $request->input("school_province");
        }

        // Modify, save and return done!
        if($applicant->modify($applicantCitizenID, $modifyThis)){

            // Mark step as done
            $applicant->markStepAsDone($applicantCitizenID, 4);

            return RESTResponse::ok();
        }else{
            // error!
            return RESTResponse::serverError('Unable to modify applicant data');
        }

    }

    /*
    | Update plan selection
    */
    public function updatePlanSelectionInformation(Request $request){

        // Get applicant object & current applicant's Citizen ID:
        $applicant = new Applicant();
        $applicantCitizenID = Session::get("applicant_citizen_id");

        // Verify inputs:
        $this->validate($request, [
            'application_type' => 'required|integer',
            'quota_type' => 'required|integer',
            'plan' => 'required|integer|min:1|max:9',
            'majors' => 'required_if:plan,5'
        ]);

        // See if we're in District Quota mode. If so, we'll always force the application type to 2:
        if(Config::get("uiconfig.mode") == "province_quota"){
            $applicationType = 2;
        }else{
            if($request->input("application_type") == 0 || $request->input("application_type") == 1){
                // Only normal application & school quota application modes allowed:
                $applicationType = (integer) $request->input("application_type");
            }else{
                // On error or any attempted injection, set to default (normal application):
                $applicationType = 0;
            }
        }

        // TODO: Any additional logic checks for DQ

        // Only consider quota types if the user has specified that he/she will be applying for a quota:
        if($applicationType == 1){
            $quotaType = $request->input("quota_type");
        }else{
            $quotaType = 0;
        }

        // Prepare data:
        $modifyThis = [
            "application_type" => $applicationType,
            "quota_type" => $quotaType,
            "plan" => $request->input("plan")
        ];

        // If majoring in science, additional sub-major information will be required:
        if($request->input("plan") == 5){
            $modifyThis["majors"] = $request->input("majors");
        }else{
            // Else there is no need for sub-major information to exist:
            $modifyThis["majors"] = []; // TODO: Find a way to delete this branch
        }

        // Now that everything's ready, save and return done (hopefully)
        if($applicant->modify($applicantCitizenID, $modifyThis)){

            // Mark step as done
            $applicant->markStepAsDone($applicantCitizenID, 5);

            return RESTResponse::ok();
        }else{
            // error!
            return RESTResponse::serverError('Unable to modify applicant data');
        }


    }

    /*
    | Update application day selection
    */
    public function updateApplicationDaySelection(Request $request){
        // Get applicant object & current applicant's Citizen ID:
        $applicant = new Applicant();
        $applicantCitizenID = Session::get("applicant_citizen_id");

        // Check that we get our ID
        $this->validate($request, [
            'id' => 'required'
        ]);

        // Try to decode ID, see if it's valid:
        try{

            // Remove "adsel_":
            $id_decoded = base64_decode(substr($request->input("id"), 6));
            $id_data = explode("/", $id_decoded); // should be : YYYY / MM / DD / (morning or afternoon)

            // See if the last part is valid:
            if($id_data[3] != "morning" && $id_data[3] != "afternoon"){
                throw new Exception("Invalid Subday Value");
            }

            // See if the date really exist:
            if(DB::collection("application_days")->where("date", $id_data[0] . "/" . $id_data[1] . "/" . $id_data[2])->count() != 1){
                // Invalid date
                throw new Exception("Invalid Date Value");
            }

        }catch(\Throwable $stuff){
            // Invalid data
            return RESTResponse::makeErrorResponse(422);
        }

        // See if we still have space:
        $dateData = DB::collection("application_days")->where("date", $id_data[0] . "/" . $id_data[1] . "/" . $id_data[2])->first();
        if($id_data[3] == "morning"){
            // Morning
            if($dateData["morning_count"] >= $dateData["morning_max"]){
                // Full already
                return RESTResponse::makeErrorResponse(406, 'full');
            }else{
                DB::collection("application_days")->where("date", $id_data[0] . "/" . $id_data[1] . "/" . $id_data[2])->increment("morning_count");
            }
        }else{
            // Afternoon
            if($dateData["afternoon_count"] >= $dateData["afternoon_max"]){
                // Full already
                return RESTResponse::makeErrorResponse(406, 'full');
            }else{
                DB::collection("application_days")->where("date", $id_data[0] . "/" . $id_data[1] . "/" . $id_data[2])->increment("afternoon_count");
            }
        }

        // Remove their old reservation to make space for other applicants:
        // TODO: This seems to have a bug that prevented the block from working. Testing required.
        try{
            $applicantData = DB::collection("applicants")->where("citizen_id", $applicant_citizen_id)->first();
            $old_rsvp_data = explode("/", $applicantData["application_day"]);
            if(DB::collection("application_days")->where("date", $old_rsvp_data[0] . "/" . $old_rsvp_data[1] . "/" . $old_rsvp_data[2])->count() != 1){
                // Invalid date
                throw new Exception("Invalid Date Value");
            }
            if($old_rsvp_data[2] == "morning"){
                DB::collection("application_days")->where("date", $old_rsvp_data[0] . "/" . $old_rsvp_data[1] . "/" . $old_rsvp_data[2])->decrement("morning_count");
            }else{
                DB::collection("application_days")->where("date", $old_rsvp_data[0] . "/" . $old_rsvp_data[1] . "/" . $old_rsvp_data[2])->decrement("afternoon_count");
            }
        }catch(\Throwable $stuff){
            // DO NOTHING
        }

        // Everything should be fine, we can now continue:
        $applicationDayStringToSave = $id_data[0] . "/" . $id_data[1] . "/" . $id_data[2] . "/" . $id_data[3];

        // Save & return done!
        // Now that everything's ready, save and return done (hopefully)
        if($applicant->modify($applicantCitizenID, ["application_day" => $applicationDayStringToSave])){

            // Mark step as done
            $applicant->markStepAsDone($applicantCitizenID, 6);

            return RESTResponse::ok();
        }else{
            // error!
            return RESTResponse::serverError('Unable to modify applicant data');
        }
    }

    /*
     * Handle applicant's documents upload
     *
     */
    public function handleDocuments(Request $request, $name){
        $allowed = array(
            'image',
            'citizen_card',
            'transcript',
            'student_hr',
            'father_hr',
            'mother_hr',
        );

        // Check if document name is in allow list
        if(!in_array($name, $allowed)){
            return RESTResponse::badRequest('Document not support');
        }

        if($request->input('upload_token') != Session::get('upload_token')){
            return Redirect::to('/application/documents')->with('error', 'การเชื่อมต่อหมดอายุ กรุณาอัพโหลดเอกสารอีกครั้ง');
        }

        // Get applicant object & current applicant's Citizen ID:
        $applicant = new Applicant();
        $applicantCitizenID = Session::get("applicant_citizen_id");

        $v1 = Validator::make($request->all(), [
            'file' => 'mimetypes:image/jpeg,image/png'
        ]);

        if($v1->fails()){
            return response()->json('ไฟล์ต้องเป็นรูปภาพ JPG หรือ PNG เท่านั้น', 400);
        }

        $v2 = Validator::make($request->all(), [
            'file' => 'max:5120'
        ]);

        if($v2->fails()){
            return response()->json('ขนาดไฟล์ต้องไม่เกิน 5MB', 400);
        }

        $time = time();

        $filename = $applicantCitizenID.'_'.$name.'_'.$time.'.'.
                    $request->file('file')->getClientOriginalExtension();

        // Storing documents
        try{
            $request->file('file')->move(Config::get('filesystems.disks.document.root'), $filename);
        }catch(\Exception $e){
            Log::error($e);
            return RESTResponse::serverError('Error saving file, please try again later');
        }

        $update = array(
            'documents.'.Session::get('upload_time').'.'.$name => array(
                'file_name' => $filename,
                'check_result' => -10,
                'timestamp' => time(),
            )
        );

        // Now that everything's ready, save and return done (hopefully)
        if($applicant->modify($applicantCitizenID, $update)){
            return RESTResponse::ok();
        }else{
            // error!
            return RESTResponse::serverError('Unable to modify applicant data');
        }

    }

    public function confirmDocument(Request $request){
        if($request->input('upload_token') != Session::get('upload_token')){
            return Redirect::to('/application/documents')->with('error', 'การเชื่อมต่อหมดอายุ กรุณาอัพโหลดเอกสารอีกครั้ง');
        }

        $data = DB::collection('applicants')
                  ->where('citizen_id', Session::get('applicant_citizen_id'))
                  ->pluck('documents.'.Session::get('upload_time'))[0];

        if(count($data) !== 6){
            throw new Exception('Documents count not equal to 6');
        }

        $expected = array(
            'image',
            'citizen_card',
            'transcript',
            'student_hr',
            'father_hr',
            'mother_hr',
        );

        foreach($expected as $key){
            if(!array_key_exists($key, $data)){
                throw new Exception('Not every document exist');
            }
        }

        // This has to be done twice since MongoDB didn't have transaction
        foreach($expected as $doc_name){
            DB::collection('applicants')
                ->where('citizen_id', Session::get('applicant_citizen_id'))
                ->update([
                    'documents.'.Session::get('upload_time').'.'.$doc_name.'.check_result' => 0,
                ]);
        }

        $raw_token = base64_encode(openssl_random_pseudo_bytes(256)); // Generate secure token
        $token = strtr($raw_token, '+/=', '-_,'); // Convert generated token to be URL safe

        DB::collection('applicants')
        ->where('citizen_id', Session::get('applicant_citizen_id'))
        ->update([
            'documents.'.Session::get('upload_time').'.access_token' => $token,
        ]);

        (new Applicant)->markStepAsDone(Session::get('applicant_citizen_id'), 7);

        return RESTResponse::ok();

    }

    public function updateGradeInfo(Request $request, Applicant $applicant){
        $this->validate($request, [
            '*.subject' => 'in:sci,mat,eng,tha,soc',
            '*.code' => 'required_with:*.subject|numeric|digits:5',
            '*.grade' => 'required_with:*.subject|min:0|max:4|numeric',
        ]);

        $data = $request->all();
        unset($data['_token']);

        $data = array_values($data); // Reset array key

        if($applicant->modify(Session::get('applicant_citizen_id'), array('quota_grade' => $data))){

            // Mark step as done
            (new Applicant)->markStepAsDone(Session::get('applicant_citizen_id'), 8);

            return RESTResponse::ok();
        }else{
            // error!
            return RESTResponse::serverError('Unable to modify applicant data');
        }
    }

    public function sendDataToValkyrie(Request $request, Applicant $applicant){
        if(Applicant::allStepComplete()){
            $db = Applicant::current();

            // Get access token to be send to valkyrie
            $all_docs = DB::collection('applicants')
                            ->where('citizen_id', Session::get('applicant_citizen_id'))
                            ->pluck('documents')[0];

            if(!krsort($all_docs)){
                throw new Exception('Cannot sort documents array');
            }

            foreach($all_docs as $doc_timestamp => $doc){
                if(array_key_exists('access_token', $doc) && (!empty($doc['access_token']))){
                    $access_token = $doc['access_token'];
                    break;
                }
            }
            // Finally we've got an access token

            $payload = array(
                'title' => $db['title'],
                'fname' => $db['fname'],
                'lname' => $db['lname'],
                'title_en' => $db['title_en'],
                'fname_en' => $db['fname_en'],
                'lname_en' => $db['lname_en'],
                'gender' => $db['gender'],
                'email' => $db['email'],
                'phone' => $db['phone'],
                'birthdate' => $db['birthdate'],
                'staying_with_parent' => $db['staying_with_parent'],
                'father' => $db['father'],
                'mother' => $db['mother'],
                'guardian' => $db['guardian'],
                'school' => $db['school'],
                'graduation_year' => $db['graduation_year'],
                'gpa' => $db['gpa'],
                'school_move_in' => $db['school_move_in'],
                'school_province' => $db['school_province'],
                'address' => $db['address'],
                'application_type' => $db['application_type'],
                'quota_type' => $db['quota_type'],
                'plan' => $db['plan'],
                'majors' => $db['majors'],
                'quota_grade' => $db['quota_grade'],
                'documents' => array(
                    'timestamp' => $doc_timestamp,
                    'access_token' => $access_token,
                ),
            );

            $baseURL = Config::get("uiconfig.valkyrie_base_api_url");
            $apiKey = Config::get("uiconfig.valkyrie_api_key");

            $sendto = "$baseURL/api/v1/applicants/".$db['citizen_id'];

            // Init cURL and set stuff:
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $sendto);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

            // VERY VERY IMPORTANT: the API key header.
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "api-key: $apiKey"
            ));

            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload)); // POST data field(s)
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // run the cURL query
            $result = curl_exec($ch);
            $returnHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if(200 == $returnHttpCode){
                return json_decode($result, true);
            }else{
                return false;
            }
        }else{
            return RESTResponse::unprocessable('Not all steps have been completed');
        }
    }

    /*
     * Check if registration completed
     */
    public function registrationComplete(){

    }

    /*
     * Submit data for consideration. We'll lock the user account after this:
     */
    public function submitQuotaApplicationForEvaluation(Request $request){
        // Data we'll need
        $applicant = new Applicant();
        $applicantCitizenID = Session::get("applicant_citizen_id");

        // TODO : Test this before pull to ui
        /*$requirement = $this->verifyApplicantAgainstRequirement($request, $applicant);

        if($requirement !== true){
            return RESTResponse::badRequest($requirement);
        }*/

        $send = $this->sendDataToValkyrie($request, $applicant);

        if($send !== false){
            // Lock the account. Return done:
            $change = [
                'quota_being_evaluated' => 1,
                'evaluation_id' => $send['success']['message'],
                'evaluation_status' => 0,
            ];
            if($applicant->modify($applicantCitizenID, $change)){
                return RESTResponse::ok();
            }else{
                // error!
                return RESTResponse::serverError('Unable to modify applicant data');
            }
        }else{
            return RESTResponse::serverError('Cannot send data to valkyrie');
        }
    }

    private function verifyApplicantAgainstRequirement(Request $request, Applicant $applicant){
        $data = Applicant::current();

        $errors = [];

        try{
            if(!Requirement::verifyGrade($data['plan'], $data['quota_grade'], $data['gpa'])){
                $errors[] = 'คุณสมบัติด้านผลการศึกษาไม่ครบ';
            }

            if(!Requirement::verifyMoveIn($data['address']['home_move_in_day'], $data['address']['home_move_in_month'], $data['address']['home_move_in_year'])){
                $errors[] = 'คุณสมบัติด้านทะเบียนบ้านไม่ครบ';
            }

            if(!Requirement::verifyMoveIn($data['school_move_in']['day'], $data['school_move_in']['month'], $data['school_move_in']['year'])){
                $errors[] = 'คุณสมบัติด้านสถานศึกษาไม่ครบ';
            }

            if(!Requirement::verifyHomeAndSchool($data['address']['home']['home_province'], $data['school_province'])){
                $errors[] = 'จังหวัดในทะเบียนบ้านไม่ตรงกับจังหวัดโรงเรียน';
            }
        }catch(Throwable $e){
            Log::error($e);
            return ['เกิดข้อผิดพลาดของระบบ'];
        }

        if(empty($errors)){
            return true;
        }else{
            return $errors;
        }
    }

    public function updateEvaluationStatus(Request $request, $citizen_id){
        // TODO authenticate api call

        if(!in_array($request->input('status'), [1, -1])){
            Log::critical('Unknown status code');
            return RESTResponse::badRequest('Unknown status code');
        }

        $expected_id = DB::collection('applicants')
                        ->where('citizen_id', $citizen_id)
                        ->pluck('evaluation_id')[0];
        if($request->input('object_id') == $expected_id){
            if(!$this->notifyCore()){
                return RESTResponse::serverError('Cannot notify core');
            }

            if($request->input('status') == 1){
                DB::collection('applicants')
                ->where('citizen_id', $citizen_id)
                ->update([
                    'quota_being_evaluated' => 0,
                    'evaluation_status' => 1
                ]);

                $this->notifyUser(1);
            }else{
                DB::collection('applicants')
                ->where('citizen_id', $citizen_id)
                ->update([
                    'quota_being_evaluated' => 0,
                    'evaluation_status' => -1
                ]);

                $this->notifyUser(-1);
            }

            return RESTResponse::ok();
        }else{
            Log::critical('ID mismatch');
            return RESTResponse::badRequest('ID mismatch');
        }
    }

    public function notifyCore(){
        return true; // TODO : Remove this before production

        $baseURL = Config::get("uiconfig.core_base_api_url");
        $apiKey = Config::get("uiconfig.core_api_key");

        $sendto = "$baseURL/api/v1/applicants/".$db['citizen_id'];

        // Init cURL and set stuff:
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $sendto);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

        // VERY VERY IMPORTANT: the API key header.
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "api-key: $apiKey"
        ));

        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload)); // POST data field(s)
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // run the cURL query
        $result = curl_exec($ch);
        $returnHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if(200 == $returnHttpCode){
            return true;
        }else{
            return false;
        }
    }

    private function notifyUser($status){
        // TODO: Mail user
        return true;
    }

    /*
    | Gender formatter
    */
    public function formatGender(int $usingCustomTitle, string $title, string $gender){
        if($usingCustomTitle === 1){
          // Custom gender
          return $gender;
        }else{
          // Figure out gender
          switch($title){
            // 0,2 is male - 1,3 is female - 4 shouldn't really be defined:
            case 0:
              return 0;
            break;
            case 1:
              return 1;
            break;
            case 2:
              return 0;
            break;
            case 3:
              return 1;
            break;
            default:
              throw new \Exception("What the gender?");
          }
        }
    }

    /*
    | iForgot request handler
    */
    public function handleiForgotRequest(Request $request){
        // Applicant object
        $applicant = new Applicant();

        // Store errors, we'll send the client these:
        $errors = [];

        // Validate incoming data:
        $this->validate($request, [
            "citizenid" => "required",
            "g-recaptcha-response" => "required|captcha",
        ]);

        // Valid applicant?
        if(!$applicant->exists($request->input("citizenid"))){
             return redirect("iforgot")->with("message", "รหัสประจำตัวประชาชนไม่ถูกต้อง โปรดตรวจสอบการพิมพ์รหัสประจำตัวประชาชนอีกครั้ง")->with("alert-class", "alert-warning");
        }

        // Get userinfo:
        try{
            $applicantData = DB::collection("applicants")->where("citizen_id", $request->input("citizenid"))->first();
        }catch(\Throwable $waitWhat){
            return redirect("iforgot")->with("message", "เกิดข้อผิดพลาดของระบบ กรุณาลองใหม่อีกครั้ง (IF-1)")->with("alert-class", "alert-warning");
        }

        // Generate iForgot token:
        $partOne = str_random(40);
        $partTwo = microtime();
        $partThree = random_int(100, 999); // This function is only available on PHP7.0 and above.

        $token = hash("sha512", sha1($partOne) . $partThree . md5($partTwo));

        try{
            // Save token to DB:
            DB::collection("iforgot")->insert([
                "token" => $token,
                "citizen_id" => $request->input("citizenid"),
                "generated_on" => time(),
                "expires_on" => time() + 900
            ]);
        }catch(\Throwable $what){
            return redirect("iforgot")->with("message", "เกิดข้อผิดพลาดของระบบ กรุณาลองใหม่อีกครั้ง (IF-2)")->with("alert-class", "alert-warning");
        }

        // Prepare mail data:
        $mailData = [
            "name" => Session::get("applicant_full_name"),
            "token" => $token
        ];

        try{
            // Send a mail!
            // TODO: Add queue support
            $applicantMail = (string) $applicantData["email"];
            Mail::send('emails.iforgot', $mailData, function ($message) use ($applicantMail) {
                $message->from('forget@apply.triamudom.ac.th', 'ระบบรับสมัครนักเรียน โรงเรียนเตรียมอุดมศึกษา');
                $message->to($applicantMail)->subject("ลืมรหัสผ่าน: ขั้นตอนการเปลี่ยนรหัสผ่านใหม่");
            });
        }catch(\Throwable $mailException){
            Log::error($mailException);
            return redirect("iforgot")->with("message", "เกิดข้อผิดพลาดของระบบ กรุณาลองใหม่อีกครั้ง (IF-3)")->with("alert-class", "alert-warning");
        }

        // Yay~!
        return redirect("iforgot/done");

    }

    /*
    | iForgot link handler
    */
    public function handleiForgotLink($token){
        // See if the link exists and is still valid:
        try{
            if(DB::collection("iforgot")->where("token", $token)->count() != 1){
                // UH-OH!
                return redirect("iforgot/error")->with("message", "Token ในการรีเซ็ทรหัสผ่านไม่ถูกต้อง กรุณาส่งคำขอ reset รหัสผ่านใหม่อีกครั้ง");
            }

            // OK, now we should have the token. See if the token is still valid?
            $tokenData = DB::collection("iforgot")->where("token", $token)->first();
            if($tokenData["expires_on"] < time()){
                // Token already expired:
                // Delete token:
                DB::collection("iforgot")->where("token", $token)->delete();
                return redirect("iforgot/error")->with("message", "Token ในการรีเซ็ทรหัสผ่านหมดอายุแล้ว กรุณาส่งคำขอ reset รหัสผ่านใหม่อีกครั้ง");
            }

            // All is fine, show the iForgot new password form page:
            return response()->view("iforgot_reset_form", ["token" => $token]);

        }catch(\Throwable $waitWhat){
            Log::error($waitWhat);
            return redirect("iforgot/error")->with("message", "เกิดข้อผิดพลาดระหว่างประมวลผลคำขอ กรุณาลองใหม่อีกครั้ง");
        }
    }

    /*
    | iForgot form handler
    */
    public function handleiForgotForm(Request $request){

        // Validate stuff
        $this->validate($request, [
            "password" => "required",
            "password_confirm" => "required|same:password",
            "token" => "required",
            "g-recaptcha-response" => "required|captcha",
        ]);

        $token = $request->input("token");

        // Check token
        if(DB::collection("iforgot")->where("token", $token)->count() != 1){
            return redirect("iforgot/error")->with("message", "Token ในการรีเซ็ทรหัสผ่านไม่ถูกต้อง กรุณาส่งคำขอ reset รหัสผ่านใหม่อีกครั้ง");
        }

        // Token valid?
        $tokenData = DB::collection("iforgot")->where("token", $token)->first();
        if($tokenData["expires_on"] < time()){
            // Token already expired:
            // Delete the token
            DB::collection("iforgot")->where("token", $token)->delete();
            return redirect("iforgot/error")->with("message", "Token ในการรีเซ็ทรหัสผ่านหมดอายุแล้ว กรุณาส่งคำขอ reset รหัสผ่านใหม่อีกครั้ง");
        }

        // A-OK. Delete the token:
        DB::collection("iforgot")->where("token", $token)->delete();

        // A-OK. Process new password and save that:
        try{
            $toUpdate = [
                "password" => Hash::make($request->input("password"))
            ];

            DB::collection("applicants")->where("citizen_id", $tokenData["citizen_id"])->update($toUpdate);

            return redirect("iforgot/success");

        }catch(\Throwable $AnExplodingGalaxyNoteSeven){ // OK?
            return redirect("iforgot/error")->with("message", "เกิดข้อผิดพลาดระหว่างประมวลผลคำขอ กรุณาลองใหม่อีกครั้ง");
        }

    }

    /*
    | National ID verification
    */
    public function verifyNationalID($nationalid) // Drunk. Fix Later.
    {

        if (strlen($nationalid) == 13) {
            $natid = str_split($nationalid);

            $c1  = $natid[0] * 13;
            $c2  = $natid[1] * 12;
            $c3  = $natid[2] * 11;
            $c4  = $natid[3] * 10;
            $c5  = $natid[4] * 9;
            $c6  = $natid[5] * 8;
            $c7  = $natid[6] * 7;
            $c8  = $natid[7] * 6;
            $c9  = $natid[8] * 5;
            $c10 = $natid[9] * 4;
            $c11 = $natid[10] * 3;
            $c12 = $natid[11] * 2;

            $val1 = $c1 + $c2 + $c3 + $c4 + $c5 + $c6 + $c7 + $c8 + $c9 + $c10 + $c11 + $c12;
            $val2 = $val1 % 11;
            $val3 = 11 - $val2;
            $val4 = substr($val3, -1);

            $checkdigit = $natid[12];

            if ($val4 == $checkdigit) {
                return true;
            } else {
                return false;
            }

        } else {
            return false;
        }

    }

    /*
    | This is nothing. IT DOES NOT EXIST.
    */
    public static function ganymede(){
        return response()->view("errors.e54", [], 418);
    }


    /**
     * Check if a given ip is in a network
     * @param  string $ip    IP to check in IPV4 format eg. 127.0.0.1
     * @param  string $range IP/CIDR netmask eg. 127.0.0.0/24, also 127.0.0.1 is accepted and /32 assumed
     * @return boolean true if the ip is in this range / false if not.
     */
    public static function ipInRange( $ip, $range ) {
        if ( strpos( $range, '/' ) == false ) {
            $range .= '/32';
        }
        // $range is in IP/CIDR format eg 127.0.0.1/24
        list( $range, $netmask ) = explode( '/', $range, 2 );
        $range_decimal = ip2long( $range );
        $ip_decimal = ip2long( $ip );
        $wildcard_decimal = pow( 2, ( 32 - $netmask ) ) - 1;
        $netmask_decimal = ~ $wildcard_decimal;
        return ( ( $ip_decimal & $netmask_decimal ) == ( $range_decimal & $netmask_decimal ) );
    }

}
