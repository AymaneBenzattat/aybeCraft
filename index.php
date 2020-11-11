<?php

require_once("./Config/app.php");

if(DEBUG){
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}else{
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
}

spl_autoload_register(function ($class_name) {
    $class_name=str_replace('\\', '/', $class_name);
    $class_name=$class_name.".php";
    if(file_exists($class_name)){
        require_once($class_name);
    }else{
        echo $class_name." not found";
    }
});

use Utilities\Database;
use Utilities\Route;

include("./Config/routes.php");

if(SETUP){
    Database::setServer(DBHOST);
    Database::setUsername(DBUSER);
    Database::setPassword(DBPASS);
    Database::setDatabase(DBNAME);
    Database::setPort(DBPORT);
}


$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
$url=ltrim($_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"],APPURL);
$url=ltrim($url,$_SERVER["HTTP_HOST"]);
if(HTTPS){
    $http="https://";
}else{
    $http="http://";
}
$full_url=$http.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
define('NEWAPPURL',"$full_url");



if (isset($url)) {
    Route::resolve($url);
}
else {
    Route::resolve("/");
}

?>