<?php

namespace Controllers;

use Utilities\Controller;
use Models\User;
use ReflectionClass;
use Utilities\Storage;

class TestController extends Controller
{

	public function home(){
		$user = new User();
		$reflection = new ReflectionClass($user);
		print_r($reflection->getTraitNames());
	}

	public function image(){
		Storage::media("image.jpg", "image/png");
	}

}

?>