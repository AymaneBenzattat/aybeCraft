<?php

namespace Controllers;

use Utilities\Controller;
use Utilities\View;
use Utilities\Database;
use Models\User;
use Utilities\Auth;

class HomeController extends Controller
{
    public function welcome()
    {
        // $object=new User();
        // $object->username="hey@admin.com";
        // $object->password="azertyy";
        // $object->save();
        // print_r($object);
        // $object->hello();
        // $object->columnExists("deleted_at");
        // print_r(User::list());
        // User::delete(1);
        // $object=User::where("id","<","2")->where("id","=","1")->get();
        // echo $_GET["bruh"];
        // $object=User::get(1);
        // echo $object->email;
        // echo $object->toJson();
        // echo $object->toJsonHidden();
        // print_r($result);

        // if(Auth::login("aymane@admin.com","azerty")){
        //     echo "e";
        // }

        // echo $i." => ".$j;
        // echo $this->input("hey");
        // print_r($this->input_values);
        // phpinfo();

        View::display("home.php");

    }

    public function error404()
    {
        View::display("404.php");
    }

}

?>