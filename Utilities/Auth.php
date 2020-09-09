<?php

class Auth
{

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
}


?>