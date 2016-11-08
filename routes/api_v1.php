<?php
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// For routes that shouldn't be throttled
Route::get("flag/{flags}", function(\App\Models\Flags $flags) {
    return response($flags->toJson(149), 200)->header("Content-Type", "application/json");
});

// Routes that should be throttled
Route::group(["middleware" => "throttle:60,1"], function() {

});
