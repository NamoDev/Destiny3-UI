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

class APIController extends Controller{


    /*
    | Account creation API endpoint
    */
    public function createAccount(Request $request){
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
        abort(500, "Password doesn't match");
      }

      // TODO: Send back data on which field triggers an error

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
      $applicantObject = new Applicant();
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

}
