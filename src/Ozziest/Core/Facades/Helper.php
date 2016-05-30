<?php namespace Ozziest\Core\Facades;

use DateTime, DateInterval;

class Helper {
    
    public function isAcceptable($string)
    {
        //   [A-Za-z0-9 _!ğüşıöçĞÜŞİÖÇ<>~{}`"#$₺€£%&½'|[\]()*+,\-.\\:\/;=?@^_]+
        return true;
    }

    public function hash($value)
    {
        return md5(substr(md5(sha1($value).md5($value)), 0, 10).md5($value)).sha1($value);
    }
    
    public function salt($email, $password)
    {
        $key = getenv('app_key');
        return md5(md5($email).md5($password.sha1($key)).sha1($key));
    }
    
    public function getToken()
    {
        return md5(uniqid(md5(mt_rand()), true));
    }
    
    public function getExpiredDate($period = 'PT30M')
    {
        $now = new DateTime();
        $now = $now->add(new DateInterval($period));
        return $now->format('Y-m-d H:i:s');
    }
    
    public function randomString($length = 10) 
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    public function ip() 
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
    
    public function agent()
    {
        return md5($this->agentClear());
    }

    public function agentClear()
    {
        if (isset($_SERVER["HTTP_USER_AGENT"]))
        {
            return $_SERVER["HTTP_USER_AGENT"];
        }
    }
    
}