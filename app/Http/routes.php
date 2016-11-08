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

Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/', 'HomeController@index');

Route::group(["middleware" => "auth"], function() {
    Route::get('/nation/create', 'NationController@create');
    Route::post("/nation/create", 'NationController@createPOST');
});

Route::group(["middleware" => ["auth", "NoNation"]], function() { // Pages that require you to be logged in
    // Nation Related Pages
    Route::get("/nation/view/{id?}", "NationController@View");
    Route::get("/nations", "NationController@allNations");

    // City related Pages
    Route::get("/cities", "CityController@overview");
    Route::get("/cities/view/{id}", "CityController@view");
    Route::post("/cities/create", "CityController@create");
    Route::post("/cities/{id}/land", "CityController@buyLand");
    Route::post("/cities/{cities}/buildings/buy/{buildingtypes}", "CityController@buyBuilding");
    Route::post("/cities/{id}/buildings/sell/{bID}", "CityController@sellBuilding");

    // Alliance related pages
    Route::get("/alliance/create", "AllianceController@create");
    Route::post("/alliance/create", "AllianceController@createPOST");

    // Account related pages
	Route::get("/account", "AccountController@view");
	Route::patch("/account/edit/username", "AccountController@editUsername");
	Route::patch("/account/edit/email", "AccountController@editEmail");
    Route::patch("/account/edit/password", "AccountController@editPassword");
    Route::delete("/account/delete", "AccountController@deleteAccount");
    Route::get("/account/inbox", "MessagesController@inbox");
    Route::get("/account/inbox/create", "MessagesController@createView");
    Route::post("/account/inbox/create", "MessagesController@create");
    Route::get("/account/messages/{id}", "MessagesController@view");
    Route::put("/account/messages/update/{id}", "MessagesController@update");
});