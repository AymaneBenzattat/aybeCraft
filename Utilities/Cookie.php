<?php

namespace Utilities;

class Cookie{

    public $key;
    public $value;
    public $expiration;
    public $domain;

    public function __construct($key,$value,$expiration=NULL,$domain=NULL){
        $this->key=$key;
        $this->value=$value;
        if(is_null($expiration)){$this->expiration=time()+31556926;}else{$this->expiration=$expiration;}
        if(is_null($domain)){$this->domain=$_SERVER['HTTP_HOST'];}else{$this->domain=$domain;}
    }

    public function save(){
        $encrypted=Security::encrypt($this->value)."$".Security::encrypt($this->expiration)."$".Security::encrypt($this->domain);
        if(is_null($this->domain)){\setcookie($this->key,$encrypted,$this->expiration);}else{\setcookie($this->key,$encrypted,$this->expiration,$this->domain);}
    }

    public static function get($key){
        if (isset($_COOKIE[$key])) {
            $encrypted=urldecode($_COOKIE[$key]);
            $elements=\explode("$",$encrypted);
            $value=Security::decrypt($elements[0]);
            $expiration=Security::decrypt($elements[1]);
            $date = (new \DateTime())->setTimestamp($expiration);
            $expiration=$date->format("Y-m-d H:i:s");
            $domain=Security::decrypt($elements[2]);
            $cookie=new Cookie($key,$value,$expiration,$domain);
            return $cookie;
        }else{
            return false;
        }
    }

    public static function delete($key){
        unset($_COOKIE[$key]);
        \setcookie($key,NULL,time() - 36000);
    }

}

?>