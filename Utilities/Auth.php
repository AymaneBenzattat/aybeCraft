<?php

namespace Utilities;

// use Models;

class Auth
{

    private static $model = "User";
    private static $username = "username";
    private static $password = "password";
    private static $user_type_table = "User";
    private static $user_type_column = "user_type";
    private static $permission_table = "Permissions";
    private static $permission_column = "name";
    private static $user_foreign_key = "id_user";
    private static $currentUser;

    private static function getConfig(){
        include("./Config/auth.php");
        if(isset($config_values["model"])){
            self::$model=$config_values["model"];
        }
        if(isset($config_values["username"])){
            self::$username=$config_values["username"];
        }
        if(isset($config_values["password"])){
            self::$password=$config_values["password"];
        }
        if(isset($config_values["user_type_table"])){
            self::$user_type_table=$config_values["user_type_table"];
        }
        if(isset($config_values["user_type_column"])){
            self::$user_type_column=$config_values["user_type_column"];
        }
        if(isset($config_values["permission_table"])){
            self::$permission_table=$config_values["permission_table"];
        }
        if(isset($config_values["permission_column"])){
            self::$permission_column=$config_values["permission_column"];
        }
        if(isset($config_values["user_foreign_key"])){
            self::$user_foreign_key=$config_values["user_foreign_key"];
        }
    }

    public static function once($username,$password){
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
                self::$currentUser=$static_instance->get($user["id"]);
                return self::$currentUser;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public static function login($username,$password){
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

    public static function isType($type){
        self::getConfig();
        $reflection=new \ReflectionClass("Models\\".self::$model);
        $currentUser = $reflection->newInstance();
        $table=$currentUser->getTable();
        $id=$currentUser->getId_column();
        $database=DBNAME;
        $usercol=self::$username;
        $typetab=self::$user_type_table;
        $typecol=self::$user_type_column;
        Database::selectOne("SELECT  FROM `".$database."`.`".$table."` WHERE ".$usercol."=?",$username);
    }

}


?>