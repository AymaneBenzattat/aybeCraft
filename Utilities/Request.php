<?php

namespace Utilities;

class Request{
    public static function post($arg){
        if (isset($_POST[$arg])) {
            return $_POST[$arg];
        }else{
            return NULL;
        }
    }
}

?>