<?php

namespace Utilities;

// use Models;

class Auth
{

    private static $model = "User";
    private static $username = "username";
    private static $password = "password";

    private static function getConfig(){
        include("./Config/auth.php");
        // print_r($config_values);
        if(isset($config_values["model"])){
            self::$model=$config_values["model"];
        }
        if(isset($config_values["username"])){
            self::$username=$config_values["username"];
        }
        if(isset($config_values["model"])){
            self::$model=$config_values["model"];
        }
    }

    public static function logUser($username,$password){
        self::getConfig();
        $reflection=new \ReflectionClass("Models\\".self::$model);
        $currentUser = $reflection->newInstance();
        $table=$currentUser->getTable();
        $id=$currentUser->getId_column();
        $database=DBNAME;
        $usercol=self::$username;
        $result=Database::selectOne("SELECT COUNT(".$id.") as mycount FROM `".$database."`.`".$table."` WHERE ".$usercol."=?",$username);
        if($result["mycount"]>0){
            $user=Database::selectOne("SELECT * FROM `".$database."`.`".$table."` WHERE ".$usercol."=?",$username);
            if(password_verify($password,$user["password"])){
                $static_reflection=new \ReflectionClass("Models\\".self::$model);
                $static_instance=$static_reflection->newInstanceWithoutConstructor();
                $currentUser=$static_instance->get($user["id"]);
                self::setUser($currentUser);
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public static function setUser($user){
        $_SESSION["auth_current_user"]=serialize($user);
    }

    public static function getUser(){
        if(isset($_SESSION["auth_current_user"])){
            return unserialize($_SESSION["auth_current_user"]);
        }else{
            return null;
        }
    }

    public static function isAuth(){
        return isset($_SESSION["auth_current_user"]);
    }

    public static function logout(){
        unset($_SESSION["auth_current_user"]);
    }

}


?>