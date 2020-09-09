<?php

class SetupController
{
    public static function setup($page)
    {
        View::return("setup/page-".$page.".php");
    }

    public static function start()
    {
        View::return("setup/start.php");
    }
}

?>