<?php

Route::get("/","HomeController::welcome");
Route::get("/based","HomeController::based");

Route::error404("HomeController::error404");


?>