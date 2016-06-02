<?php namespace Ozziest\Core\Helpers;

class TokenHelper {
    
    public static function hash($value)
    {
        return md5(substr(md5(sha1($value).md5($value)), 0, 10).md5($value)).sha1($value);
    }
    
    public static function salt($email, $password)
    {
        $key = getenv('app_key');
        return md5(md5($email).md5($password.sha1($key)).sha1($key));
    }
    
    public static function generate()
    {
        return md5(uniqid(md5(mt_rand()), true));
    }
    
}