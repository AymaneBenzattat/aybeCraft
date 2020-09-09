<?php

class Route
{
    public static $routes=[];

    public static function server(){
        return $_SERVER['REQUEST_METHOD'];
    }

    private static function urlRE($url)
    {   
        //echo $url;
        $re = '/{[a-zA-Z0-9_]+\}/';
        preg_match_all($re, $url, $matches, PREG_SET_ORDER, 0);
        $urlre=$url;
        foreach ($matches as $match) {
            $urlre=str_replace($match[0],"[a-zA-Z0-9_]+",$urlre);
            $match[0]=str_replace("{","",$match[0]);
            $match[0]=str_replace("}","",$match[0]);
            //echo $match[0];
        }
        //echo "<br>";
        //echo $urlre;
        $urlre="~^".$urlre."$~";
        return $urlre;
    }

    private static function urlArgs($url)
    {
        $re = '/{[a-zA-Z0-9_-]+\}/';
        preg_match_all($re, $url, $matches, PREG_SET_ORDER, 0);
        $urlre=$url;
        $args=[];
        foreach ($matches as $match) {
            $urlre=str_replace($match[0],"[a-zA-Z0-9_-]+",$urlre);
            $match[0]=str_replace("{","",$match[0]);
            $match[0]=str_replace("}","",$match[0]);
            array_push($args,$match[0]);
            //echo $match[0];
        }
        //echo "<br>";
        //echo $urlre;
        $urlre="~^".$urlre."$~";
        //print_r($args);
        return $args;
    }

    public static function urlMatch($request,$url){
        $re = self::urlRE($url);
        preg_match_all($re, $request, $matches, PREG_SET_ORDER, 0);
        //$urlre=$url;
        //echo "<br>";
        foreach ($matches as $match) {
            //echo $match[0];
        }
        if(count($matches)>0){
            return true;
        }
        else{
            return false;
        }
        //echo "<br>";
    }

    public static function callMethod($args,$method)
    {
        $methodParts=explode("::",$method);
        $ReflectionMethod =  new \ReflectionMethod($methodParts[0], $methodParts[1]);

        $params = $ReflectionMethod->getParameters();

        $paramNames = array_map(function( $item ){
            return $item->getName();
        }, $params);

        //print_r($paramNames);
        //print_r($args);
        //echo "<br>";

        foreach ($paramNames as $param) {
            //echo $param;
            foreach ($args as $key => $value) {
                if ($key==$param) {
                    $values[$key]=$value;
                }
            }
        }

        if (!isset($values)) {
            $values=[];
        }

        forward_static_call_array($method,$values);
    }

    public static function resolve($request){
        $routes=self::$routes;
        $server=self::server();
        //echo $server;
        $args=[];
        $error404=true;
        foreach ($routes as $route) {
            if ($route[0]==$server) {
                if (self::urlMatch($request,$route[1]) || self::urlMatch($request,$route[1]."/")) {
                    $params=self::urlArgs($route[1]);
                    $parts1 = explode("/", $route[1]);
                    //echo $route[1]."<br>";
                    //echo $request."<br>";
                    $parts2 = explode("/", $request);
                    $j=0;
                    for ($i=0; $i < count($parts2); $i++) {
                        //echo $parts2[$i]." == ".$parts1[$i]."<br>";
                        if ($parts2[$i]!=$parts1[$i]) {
                            //array_push($args,$parts2[$i]);
                            //echo ">".$i."<";
                            $args[$params[$j]]=$parts2[$i];
                            $j++;
                        }
                    }
                    self::callMethod($args,$route[2]);
                    //print_r($args);
                    $error404=false;
                }
                else{
                    //echo "ff";
                }
                //print_r($route);
            }
        }
        if ($error404) {
            echo "error404";
        }
    }

    public static function get($url,$function)
    {
        array_push(self::$routes,["GET",ltrim($url, "/"),$function]);
    }

    public static function post($url,$function)
    {
        array_push(self::$routes,["POST",ltrim($url, "/"),$function]);
    }



}

?>