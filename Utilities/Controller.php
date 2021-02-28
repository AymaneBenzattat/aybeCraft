<?php

namespace Utilities;

class Controller{

    protected $input_values;
    protected $headers;
    protected $cookies;

    public function __construct(){
        parse_str(file_get_contents("php://input"), $this->input_values);
        foreach ($this->input_values as $key => $value)
        {
            unset($this->input_values[$key]);
            $this->input_values[str_replace('amp;', '', $key)] = $value;
        }
        $_REQUEST = array_merge($_REQUEST, $this->input_values);
        $this->input_values=$_REQUEST;
        foreach (\getallheaders() as $key => $value) {
            $this->headers[$key]=$value;
        }
        foreach ($_COOKIE as $key => $value) {
            $this->cookies[$key]=$value;
        }
    }

    public function input($arg){
        if (isset($this->input_values[$arg])) {
            return $this->input_values[$arg];
        }else{
            return false;
        }
    }

    public function header($arg){
        if (isset($this->headers[$arg])) {
            return $this->headers[$arg];
        }else{
            return false;
        }
    }

    public function cookie($arg){
        if (isset($this->cookies[$arg])) {
            return $this->cookies[$arg];
        }else{
            return false;
        }
    }

    public function csrf($token="csrf-token"){
        if(!$this->input($token) && !$this->header($token)){
            return false;
        }elseif(!$this->input($token)){
            return Security::csrf($this->header($token));
        }elseif(!$this->header($token)){
            return Security::csrf($this->input($token));
        }
    }

    public function getCsrf(){
        return $_SESSION["csrf-token"];
    }

    public function toJson(){
        return json_encode($this->input_values);
    }

    public function has(){
        $return=true;
        foreach (\func_get_args() as $arg) {
            if (!$this->input($arg)) {
                $return=false;
            }
        }
        return $return;
    }

}

?>