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



    }

}
