<?php

namespace Controllers;

use Utilities\Controller;
use Utilities\View;
use Utilities\Database;
use Utilities\Route;
use Models\User;
use Utilities\Storage;
use Utilities\Response;
use Utilities\Auth;
use Utilities\Config;
use Utilities\Cookie;
use Utilities\Security;

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
        // $object=User::where("id","<","2")->where("id","=","1")->list();
        // \print_r($object);
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
        // $bruh="ddd";
        // View::display("home.php");
        // print_r($this->headers);
        // echo Config::get("auth");
        // $user=new User();
        // $user->email="aymane@admin.com";
        // $user->password="password";
        // $user->name="Aymane Benzattat";
        // $user->save();
        // echo $this->getCsrf();
        // Storage::download("fol/fol22");
        // $variableName = 'foo';
        // $foo = 'bar';

        // // The following are all equivalent, and all output "bar":
        // echo $foo;
        // echo ${$variableName};
        // echo $$variableName;

        // //similarly,
        // $variableName  = 'foo';
        // $$variableName = 'bar';

        // // The following statements will also output 'bar'
        // echo $foo; 
        // echo $$variableName; 
        // echo ${$variableName};
        // Response::goBack();
        // $cookie = new Cookie("hello","aymane");
        // $cookie->save();
        // $cookie=Cookie::get("hello");
        // print_r($cookie);
        // Cookie::delete("hello");
        // echo Security::encrypt("aymane");
        // $object=User::where("id","=",1)->get();
        // $object->password="password";
        // $object->save();
        // echo php_ini_loaded_file();
        // echo Config::get("app","model");
        if (Route::has("/Login")) {
            $auth = true;
        }else {
            $auth = false;
        }
        // print_r(Config::getYaml("app","APPURL"));
        // phpinfo();
        View::display("home.php",compact("auth"));
    }

    public function error404()
    {
        View::display("404.php");
    }

}

?>