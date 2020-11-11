<?php

namespace Utilities;

class Console{
    private $bg_colors=array(
        "default" => 49,
        "black" => 40,
        "red" => 41,
        "green" => 42,
        "yellow" => 43,
        "blue" => 44,
        "magenta" => 45,
        "cyan" => 46,
        "light gray" => 47,
        "dark gray" => 100,
        "light red" => 101,
        "light green" => 102,
        "light yellow" => 103,
        "light blue" => 104,
        "light magenta" => 105,
        "light cyan" => 106,
        "white" => 107,
    );
    private $fg_colors=array(
        "default" => 39,
        "black" => 30,
        "red" => 31,
        "green" => 32,
        "yellow" => 33,
        "blue" => 34,
        "magenta" => 35,
        "cyan" => 36,
        "light gray" => 37,
        "dark gray" => 90,
        "light red" => 91,
        "light green" => 92,
        "light yellow" => 93,
        "light blue" => 94,
        "light magenta" => 95,
        "light cyan" => 96,
        "white" => 97,
    );

    public function get($string,$foreground="default",$background="default"){
        $fg="\e[".$this->fg_colors[$foreground]."m";
        $bg="\e[".$this->bg_colors[$background]."m";
        return $fg.$bg.$string;
    }

    public function print($string,$foreground="default",$background="default"){
        echo $this->get($string,$foreground,$background);
    }

    public function printLine($string,$foreground="default",$background="default"){
        $this->print($string,$foreground,$background);
        echo "\n";
    }

    public function background($color="default"){
        return "\e[".$this->bg_colors[$color]."m";
    }

    public function foreground($color="default"){
        return "\e[".$this->fg_colors[$color]."m";
    }

}

?>