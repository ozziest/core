<?php namespace Ozziest\Core\Helpers;

class HttpHelper {

    public static function ip() 
    {
        
        if (isset($_SERVER['HTTP_CLIENT_IP']))
        {
            return $_SERVER['HTTP_CLIENT_IP'];
        } 
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } 
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
        {
            return $_SERVER['HTTP_X_FORWARDED'];
        } 
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        {
            return $_SERVER['HTTP_FORWARDED_FOR'];
        } 
        else if(isset($_SERVER['HTTP_FORWARDED']))
        {
           return $_SERVER['HTTP_FORWARDED']; 
        } 
        else if(isset($_SERVER['REMOTE_ADDR']))
        {
            return $_SERVER['REMOTE_ADDR'];
        }
            
        return 'UNKNOWN';

    }    
    
    public static function agent()
    {
        if (isset($_SERVER["HTTP_USER_AGENT"]))
        {
            return $_SERVER["HTTP_USER_AGENT"];
        }
    }

    public static function agentMd5()
    {
        return md5(self::agent());
    }

}