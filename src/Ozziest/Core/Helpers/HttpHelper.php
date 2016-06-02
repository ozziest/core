<?php namespace Ozziest\Core\Helpers;

class HttpHelper {

    public static function ip() 
    {
        
        if (getenv('HTTP_CLIENT_IP'))
        {
            return getenv('HTTP_CLIENT_IP');
        } 
        else if (getenv('HTTP_X_FORWARDED_FOR'))
        {
            return getenv('HTTP_X_FORWARDED_FOR');
        } 
        else if(getenv('HTTP_X_FORWARDED'))
        {
            return getenv('HTTP_X_FORWARDED');
        } 
        else if(getenv('HTTP_FORWARDED_FOR'))
        {
            return getenv('HTTP_FORWARDED_FOR');
        } 
        else if(getenv('HTTP_FORWARDED'))
        {
           return getenv('HTTP_FORWARDED'); 
        } 
        else if(getenv('REMOTE_ADDR'))
        {
            return getenv('REMOTE_ADDR');
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