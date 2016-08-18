<?php

namespace App\Applicant;

/*
|
| DestinyUI 3.0
| (C) 2016 TUDT
|
| Applicant model
|
*/

use Config;
use DB;
use Hash;
use Session;

class Applicant{

    /*
    | create
    | A method for creating an applicant.
    | Requires a lot of variables. Hopefully, they should be self-explanatory:
    */
    public function create(
        string $citizenID,
        string $title,
        string $firstName,
        string $lastName,
        string $title_en,
        string $firstName_en,
        string $lastName_en,
        int $gender,
        string $email,
        string $phone,
        int $birthday,
        int $birthmonth,
        int $birthyear,
        string $password
    ){
        // See if an applicant with this CitizenID exists in the system.
        // If so, throw an exception:
        if(DB::collection("applicants")->where("citizenid", $citizenID)->count() != 0){
            throw new \Exception("Duplicate application requests are not allowed");
        }else{
            // Continue.
            // TODO: Implement any more checks as required
            $insertID = DB::collection("applicants")->insertGetId([
              'citizenid' => $citizenID,
              'title' => $title,
              'fname' => $firstName,
              'lname' => $lastName,
              'title_en' => $title_en,
              'fname_en' => $firstName_en,
              'lname_en' => $lastName_en,
              'gender' => $gender,
              'email' => $email,
              'phone' => $phone,
              'birthday' => $birthday,
              'birthmonth' => $birthmonth,
              'birthyear' => $birthyear,
              'password' => Hash::make($password)
            ]);
            return string($insertID);
        }
    }

    /*
    | login
    | Applicant login processor
    | Requires citizenid and password. It's that simple!
    */
    public function login(string $citizenid, string $password){
      // See if the user exists:
      if(DB::collection("applicants")->where("citizenid", $citizenid)->count() == 1){
        // OK. Password correct?
        $loginUserData = DB::collection("applicants")->where("citizenid", $citizenid)->first();
        if(Hash::check($password, $loginUserData->password)){
          // Login OK
          Session::put("applicant_logged_in", "1");
          Session::put("applicant_citizen_id", $loginUserData->citizenid);
          Session::put("applicant_full_name", $loginUserData->fname . " " . $loginUserData->lname);
          return true;
        }else{
          // Login failed
          return false;
        }
      }else{
        // User does not exist
        return false;
      }
    }

    /*
    | logout
    | The complete opposite of login.
    | No variables required.
    */
    public function logout(){
      Session::flush();
      Session::regenerate();
      return true;
    }

    /*
    | isLoggedIn
    | Is the user logged in or not?
    | No variables required.
    */
    public function isLoggedIn(){
      if(Session::get("applicant_logged_in") == 1){
        // Yep.
        return true;
      }else{
        // Nope.
        return false;
      }
    }


}
