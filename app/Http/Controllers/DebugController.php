<?php
namespace App\Http\Controllers;

use Applicant;
use Illuminate\Http\Request;

class DebugController extends Controller{
  public function show_phpinfo(){
    phpinfo();
  }
}
