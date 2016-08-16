<?php

/*
|
| DestinyUI 3.0
| (C) 2016 TUDT
|
| UI Pages controller
|
*/

namespace App\Http\Controllers;

class UIPages extends controller{

    public function homepage(){
        return response()->view('welcome');
    }

}
