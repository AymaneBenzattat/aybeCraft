<?php

class HomeController
{
    public static function welcome()
    {
        View::return("home.php");
    }

    public static function error404()
    {
        View::return("404.php");
    }

    public static function based(){
        $test=new User();
        $test->name="Admin";
        $test->id=3;
        $test->pass="azerty";
        $test->save();
        $result=User::get(1);
        echo json_encode($result);
    }

}



?>