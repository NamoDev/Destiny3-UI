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

    public static function formatCitizenIDforDisplay(string $citizenID){
        try{
            $splitted = str_split($citizenID);
            return $splitted[0] . " - " . $splitted[1] . $splitted[2] . $splitted[3] . $splitted[4] . " - " . $splitted[5] . $splitted[6] . $splitted[7] . $splitted[8] . $splitted[9] . " - " . $splitted[10] . $splitted[11]. " - " . $splitted[12];
        }catch(\Throwable $wtf){
            return $citizenID;
        }

    }

}
