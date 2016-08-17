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

class Applicant{

    /*
    | create()
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
        int $birthyear
    ){
        // See if an applicant with this CitizenID exists in the system.
        // If so, throw an exception:
        if(DB::collection("applicants")->where("citizenID", $citizenID)->count() != 0){
            throw new \Exception("Duplicate application requests are not allowed");
        }else{
            // Continue.

        }
    }

}
