<?php

namespace Utilities;

class View
{

    public static function display($file,$variables=null){
        // $dirs = array_filter(glob('./Views/*'), 'is_dir');
        // $count = count($dirs);
        $view = file_get_contents("./Views/".$file);
    
        $re = '/@section\([0-9\/a-zA-Z_-]+\)/m';
        preg_match_all($re, $view, $matches, PREG_SET_ORDER, 0);
        do{
            for($i=0;$i<count($matches);$i++){
                //$matches[$i][0]
                $layout=str_replace("@section(","",$matches[$i][0]);
                $layout=str_replace(")","",$layout);
                $section = file_get_contents("./Views/".$layout.".part.php");
                //print_r($matches);
                // echo NEWAPPURL."Views/parts/".$layout.".php";
                $view=str_replace($matches[$i][0],$section,$view);
                preg_match_all($re, $view, $matches, PREG_SET_ORDER, 0);
            }
        }while(count($matches)>1);

        $re = '/@asset\([a-zA-Z@$#! 0-9?=\.\/_-]+\)/m';
        preg_match_all($re, $view, $matches, PREG_SET_ORDER, 0);
        // print_r($matches);
        for($i=0;$i<count($matches);$i++){
            //$matches[$i][0]
            $layout=str_replace("@asset(","",$matches[$i][0]);
            $layout=str_replace(")","",$layout);
            $section = rtrim(NEWAPPURL,"/")."/Assets/".ltrim($layout);
            //print_r($matches);
            $view=str_replace($matches[$i][0],$section,$view);
        }
        
        $re = '/@url\("[a-zA-Z@$#! 0-9?=\.\/_-]+"\)/m';
        preg_match_all($re, $view, $matches, PREG_SET_ORDER, 0);
        // print_r($matches);
        for($i=0;$i<count($matches);$i++){
            //$matches[$i][0]
            $layout=str_replace("@url(\"","",$matches[$i][0]);
            $layout=str_replace("\")","",$layout);
            $layout=rtrim($layout,"/");
            $layout=ltrim($layout,"/");
            $section = rtrim(NEWAPPURL,"/")."/".ltrim($layout);
            //print_r($matches);
            $view=str_replace($matches[$i][0],$section,$view);
        }

        $re = '/@if\([><a-zA-Z@$#! 0-9?=\.\/_-]+\)/m';
        preg_match_all($re, $view, $matches, PREG_SET_ORDER, 0);
        // print_r($matches);
        for($i=0;$i<count($matches);$i++){
            //$matches[$i][0]
            $layout=str_replace("@if(","<?php if(",$matches[$i][0]);
            $layout=str_replace(")","){ ?>",$layout);
            // $layout=rtrim($layout,"/");
            // $layout=ltrim($layout,"/");
            $section=$layout;
            // //print_r($matches);
            $view=str_replace($matches[$i][0],$section,$view);
        }

        $re = '/@foreach\([><a-zA-Z@$#! 0-9?=\.\/_-]+\)/m';
        preg_match_all($re, $view, $matches, PREG_SET_ORDER, 0);
        // print_r($matches);
        for($i=0;$i<count($matches);$i++){
            //$matches[$i][0]
            $layout=str_replace("@foreach(","<?php if(",$matches[$i][0]);
            $layout=str_replace(")","){ ?>",$layout);
            // $layout=rtrim($layout,"/");
            // $layout=ltrim($layout,"/");
            $section=$layout;
            // //print_r($matches);
            $view=str_replace($matches[$i][0],$section,$view);
        }

        $re = '/@elseif\([><a-zA-Z@$#! 0-9?=\.\/_-]+\)/m';
        preg_match_all($re, $view, $matches, PREG_SET_ORDER, 0);
        // print_r($matches);
        for($i=0;$i<count($matches);$i++){
            //$matches[$i][0]
            $layout=str_replace("@elseif(","<?php }elseif(",$matches[$i][0]);
            $layout=str_replace(")","){ ?>",$layout);
            // $layout=rtrim($layout,"/");
            // $layout=ltrim($layout,"/");
            $section=$layout;
            // //print_r($matches);
            $view=str_replace($matches[$i][0],$section,$view);
        }

        $re = '/@end/m';
        preg_match_all($re, $view, $matches, PREG_SET_ORDER, 0);
        // print_r($matches);
        for($i=0;$i<count($matches);$i++){
            //$matches[$i][0]
            $layout=str_replace("@end","<?php } ?>",$matches[$i][0]);
            $section = $layout;
            // print_r($matches);
            $view=str_replace($matches[$i][0],$section,$view);
        }

        $re = '/@else/m';
        preg_match_all($re, $view, $matches, PREG_SET_ORDER, 0);
        // print_r($matches);
        for($i=0;$i<count($matches);$i++){
            //$matches[$i][0]
            $layout=str_replace("@else","<?php }else{ ?>",$matches[$i][0]);
            $section = $layout;
            // print_r($matches);
            $view=str_replace($matches[$i][0],$section,$view);
        }
       
            
    
        $view="?>".$view;
        if(!is_null($variables)){extract($variables);}
        eval($view);
        // echo $view;
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