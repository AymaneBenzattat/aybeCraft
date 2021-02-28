<?php

require_once(__DIR__."/Utilities/Core/bootstrap.php");

use Utilities\Database;
use Utilities\Route;

session_start();

if (!isset($_SESSION["csrf-token"])) {
    $_SESSION["csrf-token"]=bin2hex(openssl_random_pseudo_bytes(32));
}

if(DEBUG){
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}else{
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
}




include("./Config/routes.php");

if(SETUP){
    Database::setServer(DBHOST);
    Database::setUsername(DBUSER);
    Database::setPassword(DBPASS);
    Database::setDatabase(DBNAME);
    Database::setPort(DBPORT);
}

$oldurl=$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
$url="/";
$result=explode(APPURL,$oldurl);
if(count($result)>1) {
    $url=$result[1];
}else{
    $url=$result[0];
}
$result=explode($_SERVER["HTTP_HOST"],$url);
if(count($result)>1) {
    $url=$result[1];
}
if (!empty($url)) {
    $appurl=explode($url,$oldurl)[0];
}else{
    $appurl=$oldurl;
}
if(HTTPS){
    $http="https://";
}else{
    $http="http://";
}
$full_url=$http.$appurl;
define('NEWAPPURL',"$full_url");



if (isset($url)) {
    Route::resolve($url);
}
else {
    Route::resolve("/");
}

?>