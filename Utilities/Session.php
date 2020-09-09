<?php

class Session
{
    public $host;
    public $request;
    public $query;
    public $cookie;

    public function __construct($host)
    {
        $this->host=$host;
        $this->request=$_POST;
        $this->query=$_GET;
        $this->cookie=$_COOKIE;
    }

}


?>