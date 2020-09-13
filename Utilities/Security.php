<?php

class Security{
    private static $secret=APPKEY;

    public static function salt($string){
        return password_hash($string,PASSWORD_BCRYPT);
    }

    public static function verify($password,$hash){
        return password_verify($password,$hash);
    }

    public static function encrypt($string,$iv="ThisIsAnIVReally"){
        return openssl_encrypt($string,"aes-256-ctr",self::$secret,0,$iv);
    }

}

?>