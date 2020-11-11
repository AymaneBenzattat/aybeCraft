<?php

use Utilities\Route;
use Controllers\HomeController;

Route::get("/","HomeController::welcome");
Route::get("/Login","HomeController::login");
Route::post("/Login","");

Route::error404("HomeController::error404");

?>