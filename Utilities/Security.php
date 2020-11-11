<?php

namespace Utilities;

class Security{
    private static $secret=APPKEY;

    public static function salt($string){
        return password_hash($string,PASSWORD_BCRYPT);
    }

    public static function verify($password,$hash){
        return password_verify($password,$hash);
    }

    public static function encrypt($string){
        $iv=openssl_random_pseudo_bytes(16);
        $result=openssl_encrypt($string,"aes-256-ctr",self::$secret,0,$iv);
        $result=$iv.$result;
        return $result;
    }

    public static function decrypt($string){
        $iv = substr($string, 0, 16);
        $string = substr($string, 16);
        $result = openssl_decrypt($string, "aes-256-ctr", self::$secret, 0, $iv);
        return $result;
    }

}

?>