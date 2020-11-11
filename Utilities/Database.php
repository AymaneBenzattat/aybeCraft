<?php

namespace Utilities;

class Database
{
    private static $server = "localhost";
    private static $username = "root";
    private static $password = "";
    private static $database = "abcraft";
    private static $port = 3306;

    public static function connect(){
        $link = mysqli_init();
        $db=mysqli_connect(self::$server,self::$username,self::$password,self::$database,self::$port);
        return $db;
    }

    public static function setServer($server)
    {
        self::$server=$server;
    }

    public static function setUsername($username)
    {
        self::$username=$username;
    }

    public static function setPassword($password)
    {
        self::$password=$password;
    }

    public static function setDatabase($database)
    {
        self::$database=$database;
    }

    public static function setPort($port)
    {
        self::$port=$port;
    }

    public static function getServer()
    {
        return self::$server;
    }

    public static function getUsername()
    {
        return self::$username;
    }

    public static function getPassword()
    {
        return self::$password;
    }

    public static function getDatabase()
    {
        return self::$database;
    }

    public static function getPort()
    {
        return self::$port;
    }

    public static function update() {
        $sql=func_get_arg(0);

        $args=[];
        for ($i=1; $i < count(func_get_args()); $i++) { 
            array_push($args,func_get_arg($i));
        }

        $conn=self::connect();
        $stmt = $conn->prepare($sql);
        $type="";
        foreach ($args as $p) {
            if(gettype($p)=="integer" || empty($p)){
                $type=$type."i";
            }elseif(gettype($p)=="string" || is_null($p)){
                $type=$type."s";
            }elseif(gettype($p)=="double"||gettype($p)=="float"){
                $type=$type."d";
            }
        }
        $params=[];

        foreach ($args as $p) {
            if(is_null($p) || empty($p)){
                $p="";
            }
            array_push($params, $p);
        }

        // print_r($args);
        // print($sql);
        // echo $type;

        if(count($params)>0){
            $stmt->bind_param($type, ...$params);
        }
        //$stmt->bind_param($type, ...$params);
        return $stmt->execute() or die($conn->error);
    }

    public static function selectOne() {
        $sql=func_get_arg(0);

        // print_r(func_get_args());

        $args=[];
        for ($i=1; $i < count(func_get_args()); $i++) { 
            array_push($args,func_get_arg($i));
        }

        $conn=self::connect();
        $stmt = $conn->prepare($sql);
        $type="";
        foreach ($args as $p) {
            if(gettype($p)=="integer" || empty($p)){
                $type=$type."i";
            }elseif(gettype($p)=="string" || is_null($p)){
                $type=$type."s";
            }elseif(gettype($p)=="double"||gettype($p)=="float"){
                $type=$type."d";
            }
            
        }
        $params=[];

        foreach ($args as $p) {
                array_push($params, $p);
            
        }
        // print_r($params);

        // echo $sql;

        if(count($params)>0){
            $stmt->bind_param($type, ...$params);
        }
        
        $stmt->execute() or die($conn->error);
        $result = $stmt->get_result();
        $return=$result->fetch_assoc();
        //print_r($return);
        return $return;
    }

    public static function selectMany() {
        $sql=func_get_arg(0);

        $args=[];
        for ($i=1; $i < count(func_get_args()); $i++) { 
            array_push($args,func_get_arg($i));
        }

        $conn=self::connect();
        $stmt = $conn->prepare($sql);
        $type="";
        foreach ($args as $p) {
            if(true){
                if(gettype($p)=="integer" || empty($p)){
                $type=$type."i";
                }elseif(gettype($p)=="string" || is_null($p)){
                    $type=$type."s";
                }elseif(gettype($p)=="double"||gettype($p)=="float"){
                    $type=$type."d";
                }
                
            }
            
        }
        $params=[];

        foreach ($args as $p) {
            if(true){
                array_push($params, $p);
            }
            
        }
        //print_r($params);
        if(count($params)>0){
            $stmt->bind_param($type, ...$params);
        }
        
        $stmt->execute() or die($conn->error);
        $result = $stmt->get_result();
        $return=[];
        while($row=$result->fetch_assoc()){
            //print_r($row["id_account"]);
            array_push($return,$row);
        }
        //print_r($return);
        return $return;
    }



}


?>