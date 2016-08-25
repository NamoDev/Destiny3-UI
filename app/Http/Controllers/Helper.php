<?php

/*
|
| DestinyUI 3.0
| (C) 2016 TUDT
|
| Helper functions (a.k.a. "UI cheats")
|
*/

namespace App\Http\Controllers;

use Applicant;
use DB;
use Session;

class Helper extends Controller{

    public static function checkStepCompletion(int $step){
        try{
            $applicantData = DB::collection("applicants")->where("citizenid", Session::get("applicant_citizen_id"))->first();
            if(in_array($step, $applicantData['steps_completed'])){
                return true;
            }else{
                return false;
            }
        }catch(\Throwable $whatever){
            return false;
        }
    }

}
