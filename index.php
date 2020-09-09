<?php

require_once("app.php");

if(DEBUG){
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}else{
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
}


foreach (glob("./Controllers/*.php") as $filename)
{
    require_once $filename;
}
foreach (glob("./Utilities/*.php") as $filename)
{
    require_once $filename;
}
require_once("routes.php");

if(SETUP){
    Database::setServer(DBHOST);
    Database::setUsername(DBUSER);
    Database::setPassword(DBPASS);
    Database::setDatabase(DBNAME);
}

$GLOBALS["session"]=new Session($_GET["hostname"]);
// echo "hey"."<br>";
// echo $session->host."<br>";
// echo "hey"."<br>";

if (isset($_GET["url"])) {
    // echo $url=$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".$_GET["url"];
    Route::resolve($_GET["url"]);
}
else {
    Route::resolve("/");
}

?>