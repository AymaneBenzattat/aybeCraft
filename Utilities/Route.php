<?php

namespace Utilities;
use Controllers;

class Route
{
    public static $routes=[];

    public static function server(){
        return $_SERVER['REQUEST_METHOD'];
    }

    private static function urlRE($url)
    {   
        $re = '/{[a-zA-Z0-9_]+\}/';
        preg_match_all($re, $url, $matches, PREG_SET_ORDER, 0);
        $urlre=$url;
        foreach ($matches as $match) {
            $urlre=str_replace($match[0],"[a-zA-Z0-9_]+",$urlre);
            $match[0]=str_replace("{","",$match[0]);
            $match[0]=str_replace("}","",$match[0]);
        }
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
        $urlre="~^".$urlre."$~";
        return $args;
    }

    public static function urlMatch($request,$url){
        $re = self::urlRE($url);
        preg_match_all($re, $request, $matches, PREG_SET_ORDER, 0);
        if(count($matches)>0){
            return true;
        }
        else{
            return false;
        }
    }

    public static function callMethod($args,$method)
    {
        $method="Controllers\\".$method;
        $methodParts=explode("::",$method);
        $reflectionMethod =  new \ReflectionMethod($methodParts[0], $methodParts[1]);

        $params = $reflectionMethod->getParameters();

        $paramNames = array_map(function( $item ){
            return $item->getName();
        }, $params);

        foreach ($paramNames as $param) {
            foreach ($args as $key => $value) {
                if ($key==$param) {
                    $values[$key]=$value;
                }
            }
        }

        if (!isset($values)) {
            $values=[];
        }

        $reflection  = new \ReflectionClass($methodParts[0]);
        $object = $reflection->newInstance();
        call_user_func_array(array($object,$methodParts[1]), $values);
    }

    public static function resolve($request){
        $request=rtrim($request,"/");
        $request=ltrim($request,"/");
        $current_url = explode('?', $request);
        $request=$current_url[0];
        $routes=self::$routes;
        $server=self::server();
        $args=[];
        $error404=true;
        foreach ($routes as $route) {
            if ($route[0]==$server) {
                if (self::urlMatch($request,$route[1]) || self::urlMatch($request,$route[1]."/")) {
                    $params=self::urlArgs($route[1]);
                    $parts1 = explode("/", $route[1]);
                    $parts2 = explode("/", $request);
                    $j=0;
                    for ($i=0; $i < count($parts2); $i++) {
                        if ($parts2[$i]!=$parts1[$i]) {
                            $args[$params[$j]]=$parts2[$i];
                            $j++;
                        }
                    }
                    self::callMethod($args,$route[2]);
                    $error404=false;
                break;
                }
                else{
                }
            }
        }
        if ($error404) {
            http_response_code(404);
            self::callMethod([],self::get404()[1]);
        }
    }

    public static function get404()
    {
        foreach (self::$routes as $route) {
            if($route[0]=="404"){
                return $route;
                break;
            }
        }
    }

    public static function get($url,$function)
    {
        array_push(self::$routes,["GET",ltrim(rtrim($url, "/"),"/"),$function]);
    }

    public static function post($url,$function)
    {
        array_push(self::$routes,["POST",ltrim(rtrim($url, "/"),"/"),$function]);
    }

    public static function head($url,$function)
    {
        array_push(self::$routes,["HEAD",ltrim(rtrim($url, "/"),"/"),$function]);
    }

    public static function put($url,$function)
    {
        array_push(self::$routes,["PUT",ltrim(rtrim($url, "/"),"/"),$function]);
    }

    public static function delete($url,$function)
    {
        array_push(self::$routes,["DELETE",ltrim(rtrim($url, "/"),"/"),$function]);
    }

    public static function connect($url,$function)
    {
        array_push(self::$routes,["CONNECT",ltrim(rtrim($url, "/"),"/"),$function]);
    }

    public static function option($url,$function)
    {
        array_push(self::$routes,["OPTION",ltrim(rtrim($url, "/"),"/"),$function]);
    }

    public static function trace($url,$function)
    {
        array_push(self::$routes,["TRACE",ltrim(rtrim($url, "/"),"/"),$function]);
    }

    public static function patch($url,$function)
    {
        array_push(self::$routes,["PATCH",ltrim(rtrim($url, "/"),"/"),$function]);
    }

    public static function error404($function)
    {
        array_push(self::$routes,["404",$function]);
    }



}

?>