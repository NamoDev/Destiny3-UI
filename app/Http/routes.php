<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
| Front-end routes
*/
Route::group(['middleware' => ['web']], function(){
    Route::get('/', 'UIPages@homepage');
});

/*
| API Routes (V1.0)
*/
Route::group(['prefix' => 'api/v1', 'middleware' => ['web']], function(){

});
