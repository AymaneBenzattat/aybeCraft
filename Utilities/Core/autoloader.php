<?php

spl_autoload_register(function ($class_name) {
    $class_name = str_replace('\\', '/', $class_name);
    $class_name = $class_name . ".php";
    if (file_exists($class_name)) {
        require_once($class_name);
    } else {
        echo $class_name . " not found";
    }
});

?>