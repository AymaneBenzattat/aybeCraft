<?php

namespace Utilities;

class Storage{
    public static function image($name){
        $target_dir = realpath(dirname(__FILE__))."/../Storage/img/";
        $filename = rand(0,9999999).basename($_FILES[$name]["name"]);
        $path = $target_dir . $filename;

        

        move_uploaded_file($_FILES[$name]['tmp_name'], $path);
        

        return $filename;
    }

    public static function upload($name,$folder="",$rand=false){
        $target_dir = realpath(dirname(__FILE__))."/../Storage/".$folder;
        if(!$rand){
            $filename=basename($_FILES[$name]["name"]);
        }else{
            $filename = rand(0,9999999).basename($_FILES[$name]["name"]);
        }
        $path = $target_dir . $filename;

        

        move_uploaded_file($_FILES[$name]['tmp_name'], $path);
        

        return $filename;
    }

    public static function make($folder){
        mkdir(realpath(dirname(__FILE__))."/../Storage/".$folder);
    }

    public static function delete($file){
        unlink(realpath(dirname(__FILE__))."/../Storage/".$file);
    }

    public static function remove($folder){
        rmdir(realpath(dirname(__FILE__))."/../Storage/".$folder);
    }

    public static function rename($object,$name){
        $object=realpath(dirname(__FILE__))."/../Storage/".$object;
        $name=realpath(dirname(__FILE__))."/../Storage/".$name;
        rename($object, $name);
    }

    public static function copy($object,$dest){
        $object=realpath(dirname(__FILE__))."/../Storage/".$object;
        $dest=realpath(dirname(__FILE__))."/../Storage/".$dest;
        copy($object, $dest);
    }

    // public static function move($object,$destination){
    //     $destination=rtrim($destination,"/");
    //     $destination=rtrim($destination,"\\");
    //     $destination=$destination."/";
    //     self::rename($object,$destination.$object);

    // }

    public static function download($file,$mime= "application/octet-stream"){
        $file=realpath(dirname(__FILE__))."/../Storage/".$file;
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: '.$mime);
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        }
    }

    public static function media($file, $mime = "image/png"){
        $file = realpath(dirname(__FILE__)) . "/../Storage/" . $file;
        $fp = fopen($file, 'rb');
        header("Content-Type: image/png");
        header("Content-Length: " . filesize($file));
        fpassthru($fp);
        exit;
    }

    public static function encrypt($filename){
        $file = realpath(dirname(__FILE__))."/../Storage/".$filename;
        $dest = $file.".enc";
        $key = APPKEY;
        
        $iv = openssl_random_pseudo_bytes(16);

        $error = false;
        if ($fpOut = fopen($dest, 'w')) {
            
            fwrite($fpOut, $iv);
            if ($fpIn = fopen($file, 'rb')) {
                while (!feof($fpIn)) {
                    $plaintext = fread($fpIn, 16 * 10000);
                    $ciphertext = openssl_encrypt($plaintext, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
                    
                    $iv = substr($ciphertext, 0, 16);
                    fwrite($fpOut, $ciphertext);
                }
                fclose($fpIn);
            } else {
                $error = true;
            }
            fclose($fpOut);
            self::delete($filename);
        } else {
            $error = true;
        }
        return $error ? false : $filename.".enc";
        }

        public static function decrypt($filename)
        {
            
            $dest=realpath(dirname(__FILE__))."/../Storage/".$filename;
            $file=$dest.".enc";

            $key = APPKEY;
            

            $error = false;
            if ($fpOut = fopen($dest, 'w')) {
                if ($fpIn = fopen($file, 'rb')) {
                    
                    $iv = fread($fpIn, 16);
                    while (!feof($fpIn)) {
                        $ciphertext = fread($fpIn, 16 * (10000 + 1)); 
                        $plaintext = openssl_decrypt($ciphertext, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
                        
                        $iv = substr($ciphertext, 0, 16);
                        fwrite($fpOut, $plaintext);
                    }
                    fclose($fpIn);
                } else {
                    $error = true;
                }
                fclose($fpOut);
                self::delete($filename.".enc");
            } else {
                $error = true;
            }

            return $error ? false : $dest;
        }

}

?>