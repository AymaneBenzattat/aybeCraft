<?php

use Utilities\Route;
use Controllers\HomeController;

Route::get("/","HomeController@welcome");
Route::get("/test","TestController@home");
Route::get("/image", "TestController@image");

//Auth
Route::get("/Login","AuthController@displayLogin");
Route::get("/Register", "AuthController@displayRegister");
Route::get("/Login/Vue", "AuthController@displayVue");
Route::post("/Login","AuthController@login");

//Auth API
Route::post("/API/Login","API\AuthController@login");
// Route::get("/API/Login","API\AuthController@login");
Route::post("/API/Register","API\AuthController@register");

Route::error404("HomeController@error404");

?>