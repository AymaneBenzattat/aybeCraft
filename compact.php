<?php

class Compact
{

    public static function test($id,$cat,$user)
    {
        echo "id: ".$id.", cat: ".$cat.", user: ".$user;
    }
    
}

//$params=[3,"hehe","admin"];
$id=3;
$user="admin";
$cat="lol";
//forward_static_call_array('Compact::test',compact($id,$user,$cat));
//Compact::test(4,"fruit","admin");
$args["cat"]="test";
$args["id"]=3;
$args["user"]="admin";

$ReflectionMethod =  new \ReflectionMethod("Compact", "test");

    $params = $ReflectionMethod->getParameters();

    $paramNames = array_map(function( $item ){
        return $item->getName();
    }, $params);

    print_r($paramNames);
    print_r($args);
    echo "<br>";

    foreach ($paramNames as $param) {
        //echo $param;
        foreach ($args as $key => $value) {
            if ($key==$param) {
                $values[$key]=$value;
            }
        }
    }

    forward_static_call_array('Compact::test',$values)



?>