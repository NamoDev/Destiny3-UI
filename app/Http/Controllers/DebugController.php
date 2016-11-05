<?php
namespace App\Http\Controllers;

use DB;


class DebugController extends Controller {
	public function show_phpinfo() {
		phpinfo();
	}
	
	public function deleteTestingUser() {
		DB::collection("applicants")->where("citizen_id", "1111111111119")->delete();
		echo "Done!";
	}
	
}
