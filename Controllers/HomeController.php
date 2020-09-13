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
        $test->name="Aymane";
        $test->id=3;
    }

}



?>