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
        'citizenid' => 'required',
        'birthdate' => 'required',
        'birthmonth' => 'required',
        'birthyear' => 'required',
        'email' => 'required',
        'phone' => 'required',
        'password' => 'required',
        'password_confirm' => 'required',
      ]);

      // Double check password
      if($request->input("password") != $request->input("password_confirm")){
        // Password doesn't match
        $errors[] = "password";
      }

      // Validate citizen ID
      if(!$this->verifyNationalID($request->input("citizenid"))){
          // Citizen ID error
          $errors[] = "citizenid";
      }

      // Validate emails

      // See if the user has already registered?
      if($applicantObject->alreadyRegistered($request->input("citizenid"))){
          // Already registered
          $errors[] = "already_registered";
      }

      // If there are errors, notify the frontend and stop right there.
      if(count($errors) != 0){
          // O NOES, THERE ARE ERRORS!
          return new Response(json_encode(["errors" => $errors], JSON_UNESCAPED_UNICODE), "417");
      }else{
          // A-OK. We can continue.
          if($request->customTitle == "1"){
            // Custom gender
            $genderToUse = $request->custom_gender;
          }else{
            // Figure out gender
            switch($request->title){
              // 0,2 is male - 1,3 is female - 4 is undefined
              case 0:
                $genderToUse = 0;
              break;
              case 1:
                $genderToUse = 1;
              break;
              case 2:
                $genderToUse = 0;
              break;
              case 3:
                $genderToUse = 1;
              break;
              default:
                throw new \Exception("Unknown gender");
            }
          }

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
        if(Hash::check($request->input("old_password"), $loginUserData['password'])){

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
