<?php

namespace Utilities;

class Controller{

    public $input_values;

    public function __construct(){
        parse_str(file_get_contents("php://input"), $this->input_values);

        foreach ($this->input_values as $key => $value)
        {
            unset($this->input_values[$key]);

            $this->input_values[str_replace('amp;', '', $key)] = $value;
        }

        $_REQUEST = array_merge($_REQUEST, $this->input_values);
        $this->input_values=$_REQUEST;
    }

    public function input($arg){
        if (isset($this->input_values[$arg])) {
            return $this->input_values[$arg];
        }else{
            return NULL;
        }
    }

}

?>