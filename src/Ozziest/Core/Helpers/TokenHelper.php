<?php namespace Ozziest\Core\Helpers;

class TokenHelper {
    
    /**
     * This method mixes the value 
     * 
     * @param  string   $value
     * @return string
     */
    public static function hash($value)
    {
        return md5(substr(md5(sha1($value).md5($value)), 0, 10).md5($value)).sha1($value);
    }
    
    /**
     * This method salts the password with email
     * 
     * @param  string       $email
     * @param  string       $password
     * @return string
     */
    public static function salt($email, $password)
    {
        $key = '66B1132A0173910B01EE3A15EF4E69583BBF2F7F1E4462C99EFBE1B9AB5BF808';
        return md5(md5($email).md5($password.sha1($key)).sha1($key));
    }
    
    /**
     * This method generate a new token
     * 
     * @return string
     */
    public static function generate()
    {
        return md5(uniqid(md5(mt_rand()), true));
    }
    
}