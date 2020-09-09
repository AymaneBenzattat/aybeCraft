<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$routes=[];
array_push($routes,["get","user/{id}/{item}","do"]);
array_push($routes,["get","cat/{id}","show"]);
array_push($routes,["post","form/{id}","add"]);

function get($url)
{
    $re = '/{[a-zA-Z0-9_-]+\}/';
    preg_match_all($re, $url, $matches, PREG_SET_ORDER, 0);
    $urlre=$url;
    foreach ($matches as $match) {
        $urlre=str_replace($match[0],"[a-zA-Z0-9_-]+",$urlre);
        $match[0]=str_replace("{","",$match[0]);
        $match[0]=str_replace("}","",$match[0]);
        //echo $match[0];
    }
    echo "<br>";
    //echo $urlre;
    $urlre="~^".$urlre."$~";
    return $urlre;
}

function getArgs($url)
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
    echo "<br>";
    //echo $urlre;
    $urlre="~^".$urlre."$~";
    print_r($args);
    return $args;
}

function url($request,$url){
    $re = get($url);
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

function resolve($request){
    $routes=[];
    $server="get";
    array_push($routes,["get","user/{id}/{item}","do"]);
    array_push($routes,["get","cat/{id}","show"]);
    array_push($routes,["post","form/{id}","add"]);
    $args=[];
    foreach ($routes as $route) {
        if ($route[0]==$server) {
            if (url($request,$route[1])) {
                $params=getArgs($route[1]);
                $parts1 = explode("/", $route[1]);
                echo $route[1]."<br>";
                echo $request."<br>";
                $parts2 = explode("/", $request);
                $j=0;
                for ($i=0; $i < count($parts2); $i++) {
                    echo $parts2[$i]." == ".$parts1[$i]."<br>";
                    if ($parts2[$i]!=$parts1[$i]) {
                        //array_push($args,$parts2[$i]);
                        //echo ">".$i."<";
                        $args[$params[$j]]=$parts2[$i];
                        $j++;
                    }
                }
                print_r($args);

            }
            else{
                echo "ff";
            }
            //print_r($route);
        }
    }
}

// $url = explode("/", $_GET["url"]);
// foreach($url as $piece){
//     echo $piece."=>";
// }

//get("t/{i}/{j}");

//url("user/use-r/6","user/{i}/{j}");
//print_r($routes);
resolve("user/i/4");




?>