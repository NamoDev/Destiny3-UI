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
use Illuminate\Http\Request;
use Log;
use DB;
use Session;
use Hash;
use Response;
use Storage;
use RESTResponse;
use Config;
use Base64Exception;

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
         ]);

         // TODO: fix CAPTCHA
         //'g-recaptcha-response' => 'required|captcha',

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
          return response(json_encode(["errors" => $errors], JSON_UNESCAPED_UNICODE), "409");
      }

      // If there are errors, notify the frontend and stop right there.
      if(count($errors) != 0){
          // O NOES, THERE ARE ERRORS!
          return response(json_encode(["errors" => $errors], JSON_UNESCAPED_UNICODE), "417");
      }else{

          // A-OK. We can continue.
          // Format gender data
          $genderToUse = $this->formatGender($request->customtitle, $request->title, $request->gender);

          // Create user and login!
          $applicantObject->create(
              $request->citizenid,
              $request->title,
              $request->fname,
              $request->lname,
              $request->title_en,
              $request->fname_en,
              $request->lname_en,
              $genderToUse,
              $request->email,
              $request->phone,
              $request->birthdate,
              $request->birthmonth,
              $request->birthyear,
              $request->password
          );

          // Log the user in
          $applicantObject->login($request->citizenid, $request->password);

          // return success
          echo(json_encode(['result' => 'success'], JSON_UNESCAPED_UNICODE));

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
        $applicantData = DB::collection("applicants")->where("citizenid", Session::get("applicant_citizen_id"))->first();
        if(Hash::check($request->input("old_password"), $applicantData['password'])){

            // OK
            DB::collection("applicants")->where("citizenid", Session::get("applicant_citizen_id"))->update([
                'password' => Hash::make($request->input("password")),
            ]);

            return response(json_encode(["result" => "ok"]));

        }else{
            // Old password incorrect
            return response(json_encode(["result" => "old_password_incorrect"]), 401);
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

            return response(json_encode(["status" => "ok"], JSON_UNESCAPED_UNICODE), 200);
        }else{
            // error!
            // TODO: return RESTResponse maybe?
            return response(json_encode(["status" => "error"], JSON_UNESCAPED_UNICODE), 500);
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
            return response(json_encode(["status" => "ok"], JSON_UNESCAPED_UNICODE), 200);
        }else{
            // error!
            // TODO: return RESTResponse maybe?
            return response(json_encode(["status" => "error"], JSON_UNESCAPED_UNICODE), 500);
        }

    }

    public function getDocument(Request $request, $citizen_id, $filename = null){
        /*if(!$this->ipInRange($request->ip(), $range)){
            return RESTResponse::notAuthorized('IP not in permitted range');
        }*/

        /*if(!$request->has('ACCESS-KEY')){
            return RESTResponse::badRequest('Request does not include access key');
        }*/
        // Skip validation for now, as we debate about how to handshake

        //if($request->input('type') == 'all'){

        //}else if($request->input('type') == 'pending'){
            /*$data = DB::collection('applicants')
                      ->where('citizen_id', $citizen_id)
                      ->where('')
                      ->pluck('document')[0];*/
        /*}else{
            return RESTResponse::badRequest('Invalid type');
        }*/

        if(is_null($filename)){
            // Retrieve all file
            $data = DB::collection('applicants')
                      ->where('citizen_id', $citizen_id)
                      ->pluck('document')[0];
        }else{
            $data = DB::collection('applicants')
                      ->where('citizen_id', $citizen_id)
                      ->pluck('document')[0][$filename];
        }

        if(count($data) == 0){
            return RESTResponse::notFound('No data for citizen_id : ' . $citizen_id);
        }

        if(is_null($filename)){
            $keys = array_keys($data);
            $i = 0;
            foreach($data as $doc){
                $encoded = base64_encode(Storage::disk('document')->get($doc['file_id']));
                if($encoded === false){
                    throw new Base64Exception('Cannot encode image file');
                }else{
                    $documents[$keys[$i]] = $encoded;
                }
                $i++;
            }
            unset($i);
        }else{
            $encoded = base64_encode(Storage::disk('document')->get($data['file_id']));
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
                'graduation_year' => 'required|integer',
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
            return response(json_encode(["status" => "ok"], JSON_UNESCAPED_UNICODE), 200);
        }else{
            // error!
            // TODO: return RESTResponse maybe?
            return response(json_encode(["status" => "error"], JSON_UNESCAPED_UNICODE), 500);
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
            $applicationType = (integer) $request->input("application_type");
        }

        // TODO: Any additional logic checks for DQ

        // Prepare data:
        $modifyThis = [
            "application_type" => $applicationType,
            "quota_type" => $request->input("quota_type"),
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
            return response(json_encode(["status" => "ok"], JSON_UNESCAPED_UNICODE), 200);
        }else{
            // error!
            // TODO: return RESTResponse maybe?
            return response(json_encode(["status" => "error"], JSON_UNESCAPED_UNICODE), 500);
        }


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
