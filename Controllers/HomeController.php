<?php

namespace Controllers;

use Utilities\View;
use Utilities\Database;
use Models\User;
use Utilities\Auth;

class HomeController
{
    public static function welcome()
    {
        if(Auth::logUser("aymane@admin.com","azerty")){
            echo "yes";
        }
        $object=new User();
        // $object->hello();
        $object->columnExists("deleted_at");
        // print_r(User::list());
    }

    public static function error404()
    {
        View::display("404.php");
    }

}

?>