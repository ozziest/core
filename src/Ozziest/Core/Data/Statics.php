<?php namespace Ozziest\Core\Data;

use Ozziest\Core\Exceptions\UserException;

class Statics {

    private static $list = [];
    
    public static function set($key, $values)
    {
        self::$list[$key] = $values;
    }
    
    public static function check($key, $value)
    {
        if (in_array($value, self::$list[$key]) === false)
        {
            throw new UserException("The {$key} is invalid!");
        }
    }
   
}