<?php

namespace Controllers;

use Utilities\Controller;
use Utilities\View;
use Utilities\Auth;
use Models\User;
use Utilities\Response;

class AuthController extends Controller
{

	public function displayLogin(){
		$message="";
		View::display("auth/login.html",compact("message"));
	}

	public function displayVue(){
		View::display("auth/vue.html");
	}

	public function login()
	{
		if ($this->has("username", "password")) {
			$result = Auth::login($this->input("username"), $this->input("password"));
			if ($result != false) {
				if ($this->has("remember")) {
					$object = User::get($result->id);
					if (is_null($object->remember_token)) {
						$object->remember_token = md5(openssl_random_pseudo_bytes(16));
						$object->save();
					}
				} else {
					$result->remember_token = null;
				}
				$response = new Response();
				$response->addObject($result);
				$response->send();
			} else {
				$response = new Response("⚠️ Incorrect credentials", [], 401);
				$response->send();
			}
		}else{
			$message = "Please fill all the fields";
			View::display("auth/login.html", compact("message"));
		}
	}
}

?>