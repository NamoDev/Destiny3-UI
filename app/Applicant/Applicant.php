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
use Exception;
use Hash;
use Session;
use Log;

class Applicant {

    /**
     * A method for creating an applicant. Requires a lot of variables.
     *
     * @param string $citizenID
     * @param string $title
     * @param string $firstName
     * @param string $lastName
     * @param string $title_en
     * @param string $firstName_en
     * @param string $lastName_en
     * @param int    $gender
     * @param string $email
     * @param string $phone
     * @param int    $birthday
     * @param int    $birthmonth
     * @param int    $birthyear
     * @param string $password
     * @return string Applicant's ID
     * @throws \Exception
     */
    public function create(
        string $citizen_id,
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
    ) {
        // See if an applicant with this citizen_id exists in the system.
        // If so, throw an exception:
        if (DB::collection("applicants")->where("citizen_id", $citizen_id)->count() != 0) {
            throw new \Exception("Duplicate application requests are not allowed");
        } else {
            // Continue.
            // TODO: Implement any more checks as required
            $insertID = DB::collection("applicants")->insertGetId([
                'citizen_id' => $citizen_id,
                'title' => $title,
                'fname' => $firstName,
                'lname' => $lastName,
                'title_en' => $title_en,
                'fname_en' => $firstName_en,
                'lname_en' => $lastName_en,
                'gender' => $gender,
                'email' => $email,
                'phone' => $phone,
                'birthdate' => [
                    "day" => $birthday,
                    "month" => $birthmonth,
                    "year" => $birthyear
                ],
                'password' => Hash::make($password),
                'steps_completed' => [1],
            ]);

            return (string)$insertID;
        }
    }


    /**
     * Applicant data updater (a.k.a. 'The Modifier')
     *
     * @param string $citizen_id
     * @param array  $things Array of 'things' to be modified.
     * @return bool
     */
    public function modify(string $citizen_id, array $things): bool {
        if ($this->exists($citizen_id)) {

            // Yep, our applicant exists. Do update:
            DB::collection("applicants")->where("citizen_id", $citizen_id)->update($things);

            // And we're done.
            return true;

        } else {
            // NOPE. 404 NOT FOUND.
            return false;
        }
    }

    /**
     * Mark a step as done
     *
     * @param string  $citizenid
     * @param integer $step
     * @return bool
     */
    public function markStepAsDone(string $citizenid, int $step): bool {
        if ($this->exists($citizenid)) {

            // Get applicant data
            $applicantData = DB::collection("applicants")->where("citizen_id", $citizenid)->first();

            // Yep, our applicant exists. See if the step request has already been marked as done:
            if (!in_array($step, $applicantData["steps_completed"])) {
                // Nope. Let's add it!
                $stepsCompleted = $applicantData["steps_completed"];
                $stepsCompleted[] = $step;
                DB::collection("applicants")->where("citizen_id", $citizenid)->update([
                    "steps_completed" => $stepsCompleted
                ]);
            }

            // And we're done.
            return true;

        } else {
            // NOPE. 404 NOT FOUND.
            return false;
        }
    }

    /**
     * Unmark a step as done. Boop!
     *
     * @param string  $citizenid
     * @param integer $step
     * @return bool
     */
    public function unmarkStepAsDone(string $citizenid, int $step): bool {
        if ($this->exists($citizenid)) {

            // Get applicant data
            $applicantData = DB::collection("applicants")->where("citizen_id", $citizenid)->first();

            // Search & remove step if exists
            if($index = array_search($applicantData["steps_completed"])){

                $newStepsCompleted = $applicantData["steps_completed"];
                unset($newStepsCompleted[$index]);
                DB::collection("applicants")->where("citizen_id", $citizenid)->update([
                    "steps_completed" => $newStepsCompleted
                ]);

                // And we're done!
                return true;

            }else{
                // Step cannot be removed, as it doesn't exist in the first place:
                return false;
            }

        } else {
            // NOPE. 404 NOT FOUND.
            return false;
        }
    }


    /**
     * Applicant login processor. Requires citizenid and password. It's that simple!
     *
     * @param string $citizen_id
     * @param string $password
     * @return bool
     */
    public function login(string $citizen_id, string $password): bool {
        // See if the user exists:
        if (DB::collection("applicants")->where("citizen_id", $citizen_id)->count() == 1) {
            // OK. Password correct?
            $loginUserData = DB::collection("applicants")->where("citizen_id", $citizen_id)->first();

            // Double conversion to convert Array to Object (which is easier to work with IMO)
            $loginUserData = json_decode(json_encode($loginUserData));

            if (Hash::check($password, $loginUserData->password)) {
                // Login OK
                Session::put("applicant_logged_in", "1");
                Session::put("applicant_citizen_id", $loginUserData->citizen_id);
                Session::put("applicant_full_name", $loginUserData->fname . " " . $loginUserData->lname);

                return true;
            } else {
                // Login failed
                return false;
            }
        } else {
            // User does not exist
            return false;
        }
    }


    /**
     * The complete opposite of login.
     *
     * @return bool
     */
    public function logout():bool {
        Session::flush();
        Session::regenerate();

        return true;
    }


    /**
     * Refreshes all session data (except Citizen ID).
     *
     * @return bool
     */
    public function reloadSessionData():bool {

        // Reload data from DB:
        $userData = DB::collection("applicants")->where("citizen_id", Session::get("applicant_citizen_id"))->first();
        Session::put("applicant_full_name", $userData['fname'] . " " . $userData['lname']);

        return true;

    }

    /**
     * Is the user logged in or not?
     *
     * @return bool
     */
    public function isLoggedIn(): bool {
        if (Session::get("applicant_logged_in") == 1) {
            // Yep.
            return true;
        } else {
            // Nope.
            return false;
        }
    }


    /**
     * Does the applicant exist?
     *
     * @param string $citizenid
     * @return bool
     */
    public function exists(string $citizenid): bool {
        return (DB::collection("applicants")->where("citizen_id", $citizenid)->count() != 0);
    }

    /**
     * Get current applicant's data
     *
     * @return mixed
     */
    public static function current() {
        return DB::collection("applicants")->where("citizen_id", Session::get("applicant_citizen_id"))->first();
    }

    /*
     * Check if all steps are completed. NOTE: only work on applicants who are logged in
     */
    public static function allStepComplete(){
        if(config('uiconfig.mode') == 'province_quota'){
            $required_step = array(1, 2, 3, 4, 5, 7);
        }else if(config('uiconfig.mode') == 'normal'){
            $required_step = array(1, 2, 3, 4, 5, 6);
        }else{
            throw new Exception('Operation mode misconfigured');
        }

        $completed_step = DB::collection('applicants')
                            ->where('citizen_id', Session::get('applicant_citizen_id'))
                            ->pluck('steps_completed')[0];

        try{
            foreach($required_step as $required){
                if(!in_array($required, $completed_step)){
                    return false;
                }
            }
        }catch(Exception $e){
            Log::error('steps_completed field not found');
            return false;
        }

        return true;
    }

    /*
    * Check if the applicant's quota submission is under review (account should be locked)
    * NOTE: only works on applicants who are logged in.
    */
    public static function quotaSubmissionUnderReview(){
        if(config('uiconfig.mode') == 'province_quota'){
            // Check
            if(DB::collection('applicants')->where('citizen_id', Session::get('applicant_citizen_id'))->pluck('quota_being_evaluated')[0] == 1){
                return true;
            }else{
                return false;
            }
        }else{
            // Not applicable
            return false;
        }
    }

}
