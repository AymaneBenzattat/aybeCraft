<?php

require_once(__DIR__."/autoloader.php");
use Utilities\Config;

foreach (Config::get("app") as $key => $value) {
    define($key, $value);
}

?>