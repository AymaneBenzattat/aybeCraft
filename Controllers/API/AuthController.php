<?php

namespace Controllers\API;

use Utilities\Controller;
use Utilities\Auth;
use Utilities\Response;
use Models\User;

class AuthController extends Controller
{

	public function login(){
		if ($this->has("username","password")) {
			$result=Auth::once($this->input("username"),$this->input("password"));
			if($result!=false){
				if($this->has("remember")){
					$object=User::get($result->id);
					if(is_null($object->remember_token)){
						$object->remember_token=md5(openssl_random_pseudo_bytes(16));
						$object->save();
					}
				}else{
					$result->remember_token=null;
				}
				$response = new Response();
				$response->addObject($result);
				$response->send();
			}else{
				$response = new Response("⚠️ Incorrect credentials",[],401);
				$response->send();
			}
		}elseif($this->has("remember_token")){
			echo $this->input("remember_me");
			$result = Auth::checkRememberToken($this->input("remember_token"));
			if ($result != false) {
				$response = new Response();
				$response->addObject($result);
				$response->send();
			} else {
				$response = new Response("⚠️ Incorrect credentials", [], 401);
				$response->send();
			}
		}else{
			$response = new Response("Bad request",[],400);
			$response->send();
		}
	}

	public function register(){
		if($this->has("username","password","name")){
			$user=new User();
			$user->email=$this->input("username");
			$user->name=$this->input("name");
			$user->password=$this->input("password");
			$user->save();
		}else{
			$response = new Response("Bad request",[],400);
			$response->send();
		}
	}

}

?>