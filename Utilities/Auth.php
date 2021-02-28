<?php

namespace Utilities;

// use Models;

class Auth
{

    private static $model = "User";
    private static $username = "username_field";
    private static $password = "password_field";
    private static $role_table = "Role";
    private static $role_column = "name";
    private static $permission_table = "Permission";
    private static $permission_column = "name";
    private static $currentUser;

    private static function getConfig(){
        self::$model = Config::get("auth","model");
        self::$username = Config::get("auth","username_field");
        self::$password=Config::get("auth","password_field");
        self::$role_table=Config::get("auth","role_table");
        self::$role_column=Config::get("auth","role_column");
        self::$permission_table=Config::get("auth","permission_table");
        self::$permission_column=Config::get("auth","permission_column");
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
                self::$currentUser=$static_instance->get($user[$id]);
                return self::$currentUser;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public static function checkRememberToken($token)
    {
        self::getConfig();
        $reflection = new \ReflectionClass("Models\\" . self::$model);
        $currentUser = $reflection->newInstance();
        $table = $currentUser->getTable();
        $id = $currentUser->getId_column();
        $database = DBNAME;
        $usercol = self::$username;
        $result = Database::selectOne("SELECT COUNT(" . $id . ") as mycount FROM `" . $database . "`.`" . $table . "` WHERE remember_token=?", $token);
        if ($result["mycount"] > 0) {
            $user = Database::selectOne("SELECT * FROM `" . $database . "`.`" . $table . "` WHERE remember_token=?", $token);
            $static_reflection = new \ReflectionClass("Models\\" . self::$model);
            $static_instance = $static_reflection->newInstanceWithoutConstructor();
            self::$currentUser = $static_instance->get($user[$id]);
            return self::$currentUser;
        } else {
            return false;
        }
    }
    
    public static function login($username,$password){
        self::getConfig();
        $result= self::once($username, $password);
        if ($result!=false) {
            self::setUser(self::once($username,$password));
        }
        return $result;
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
        $typetab=self::$role_table;
        $typecol=self::$role_column;
        Database::selectOne("SELECT  FROM `".$database."`.`".$table."` WHERE ".$usercol."=?",$username);
    }

    public static function hasRole($role){
        self::getConfig();
        Database::selectOne("SELECT COUNT(id) FROM ".self::$role_table." WHERE ");
    }

}

?>