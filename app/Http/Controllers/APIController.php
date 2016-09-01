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

class APIController extends Controller{

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

         // TODO: Make Citizen ID verification a part of the validator itself

         // Validate citizen ID
         if(!$this->verifyNationalID($request->input("citizenid"))){
             // Citizen ID error
             $errors[] = "citizenid";
         }


      // See if the user has already registered?
      if($applicantObject->alreadyRegistered($request->input("citizenid"))){
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

}
