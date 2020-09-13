<?php

class View
{


    public static function return($file){
        $dirs = array_filter(glob('./Views/*'), 'is_dir');
        $count = count($dirs);
        $view = file_get_contents("./Views/".$file);
        //print_r($dirs);
        
        
    
        $re = '/@section\("[a-zA-Z_-]+"\)/m';
        preg_match_all($re, $view, $matches, PREG_SET_ORDER, 0);
        for($i=0;$i<count($matches);$i++){
            //$matches[$i][0]
            $layout=str_replace("@section(\"","",$matches[$i][0]);
            $layout=str_replace("\")","",$layout);
            $section = file_get_contents("./Views/".$layout.".part.php");
            //print_r($matches);
            $view=str_replace($matches[$i][0],$section,$view);
        }
    
        preg_match_all($re, $view, $matches, PREG_SET_ORDER, 0);
        for($i=0;$i<count($matches);$i++){
            //$matches[$i][0]
            $layout=str_replace("@section(\"","",$matches[$i][0]);
            $layout=str_replace("\")","",$layout);
            $section = file_get_contents("./Views/".$layout.".part.php");
            //print_r($matches);
            $view=str_replace($matches[$i][0],$section,$view);
        }

        $re = '/@asset\("[a-zA-Z \.\/_-]+"\)/m';
        preg_match_all($re, $view, $matches, PREG_SET_ORDER, 0);
        // print_r($matches);
        for($i=0;$i<count($matches);$i++){
            //$matches[$i][0]
            $layout=str_replace("@asset(\"","",$matches[$i][0]);
            $layout=str_replace("\")","",$layout);
            $section = rtrim(APPURL,"/")."/Assets/".ltrim($layout);
            //print_r($matches);
            $view=str_replace($matches[$i][0],$section,$view);
        }
    
    
        // //$view=str_replace("=\"./","=\"",$view);
        // foreach ($dirs as $dir){
        //     $old=explode("/",$dir);
        //     //print_r($old);
        //     $view=str_replace("=\"./".$old[2]."/","=\"".$dir."/",$view);
        // }
        
       
            
    
        $view="?>".$view;
        eval($view);
    }

    public static function setMessage($key,$value){
        $_SESSION["message_".$key]=$value;
    }

    public static function getMessage($key){
        if (isset($_SESSION["message_".$key])) {
            return $_SESSION["message_".$key];
        }else {
            return null;
        }
    }

}


?>