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

Route::auth();

Route::get('/', 'HomeController@index');

Route::group(["middleware" => "auth"], function() {
    Route::get('/nation/create', 'NationController@create');
    Route::post("/nation/create", 'NationController@createPOST');
});

Route::group(["middleware" => ["auth", "NoNation"]], function() { // Pages that require you to be logged in
    Route::get("/nation/view/{id?}", "NationController@View");

    Route::get("/cities", "CityController@overview");
    Route::get("/cities/{id}", "CityController@view");
    Route::post("/cities/create", "CityController@create");
});