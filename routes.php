<?php

Route::get("/","HomeController::welcome");
Route::get("/cat/{id}","Compact::test2");
Route::get("/setup/{page}","SetupController::setup");


?>