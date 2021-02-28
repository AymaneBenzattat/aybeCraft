<?php

namespace Utilities;

class Config
{

    public static function get($file, $attribute = NULL){
        if (\file_exists(__DIR__ . "/../Config/" . $file . ".yaml")) {
            $values = \yaml_parse_file(__DIR__ . "/../Config/" . $file . ".yaml");
            if (!is_null($attribute)) {
                if (isset($values[$attribute])) {
                    return $values[$attribute];
                }else{
                    return null;
                }
            }else{
                return $values;
            }
        } else {
            return NULL;
        }
    }

    public static function getPHP($file,$attribute=NULL){        
        if(\file_exists(__DIR__."/../Config/".$file.".php")){
            include(__DIR__."/../Config/".$file.".php");
            if(is_null($attribute) && isset($values)){
                return $values;
            }elseif(isset($values[$attribute])){
                return $values[$attribute];
            }else{
                return NULL;
            }
        }else{
            return NULL;
        }
    }

}

?>