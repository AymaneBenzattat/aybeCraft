<?php

class Database
{
    private static $server = "localhost";
    private static $username = "root";
    private static $password = "";
    private static $database = "abcraft";

    public static function connect(){
        $link = mysqli_init();
        $db=mysqli_connect(self::$server,self::$username,self::$password,self::$database);
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

    public static function update() {
        $sql=func_get_arg(0);
        $conn=self::connect();
        $stmt = $conn->prepare($sql);
        $type="";
        foreach (func_get_args() as $p) {
            if($p!=func_get_arg(0)){
                if(gettype($p)=="integer"){
                    $type=$type."i";
                }
                if(gettype($p)=="string"){
                    $type=$type."s";
                }
                if(gettype($p)=="double"||gettype($p)=="float"){
                    $type=$type."d";
                }
                
            }
            
        }
        $params=[];

        foreach (func_get_args() as $p) {
            if($p!=func_get_arg(0)){
                array_push($params, $p);
                
            }
            
        }
        if(count($params)>0){
            $stmt->bind_param($type, ...$params);
        }
        //print_r($params);
        //$stmt->bind_param($type, ...$params);
        return $stmt->execute() or die($conn->error);
    }

    public static function selectOne() {
        $sql=func_get_arg(0);
        $conn=self::connect();
        $stmt = $conn->prepare($sql);
        $type="";
        foreach (func_get_args() as $p) {
            if($p!=func_get_arg(0)){
                if(gettype($p)=="integer"){
                    $type=$type."i";
                }
                if(gettype($p)=="string"){
                    $type=$type."s";
                }
                if(gettype($p)=="double"||gettype($p)=="float"){
                    $type=$type."d";
                }
                
            }
            
        }
        $params=[];

        foreach (func_get_args() as $p) {
            if($p!=func_get_arg(0)){
                array_push($params, $p);
            }
            
        }
        //print_r($params);
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
        $conn=self::connect();
        $stmt = $conn->prepare($sql);
        $type="";
        foreach (func_get_args() as $p) {
            if($p!=func_get_arg(0)){
                if(gettype($p)=="integer"){
                    $type=$type."i";
                }
                if(gettype($p)=="string"){
                    $type=$type."s";
                }
                if(gettype($p)=="double"||gettype($p)=="float"){
                    $type=$type."d";
                }
                
            }
            
        }
        $params=[];

        foreach (func_get_args() as $p) {
            if($p!=func_get_arg(0)){
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