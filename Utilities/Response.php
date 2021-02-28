<?php

namespace Utilities;

class Response
{

    private $code;
    private $message;
    private $data;

    public function __construct($message=NULL,$data=[],$code=200){
        $this->message=$message;
        $this->data=$data;
        $this->code=$code;
    }

    public function send(){
        echo $this;
    }

    public function __toString(){
        \header("Content-Type: application/json");
        \http_response_code($this->code);
        if(!is_null($this->message)){$response["message"]=$this->message;}
        $response["data"]=$this->data;
        return \json_encode($response);
    }

    public function setMessage($message)
    {
        $this->message=$message;
    }

    public function setData($data)
    {
        $this->data=$data;
    }

    public function setCode($code)
    {
        $this->code=$code;
    }

    public function addData($data){
        array_push($this->data,$data);
    }

    public function addObject(BasedObject $object){
        array_push($this->data,json_decode($object->toJson()));
    }

    public static function goBack(){
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    public static function redirect($url){
        \header("Location: ".$url);
    }

}

?>