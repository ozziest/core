<?php namespace Ozziest\Core\Data;

class Lifecycle {

    private static $data = [];
    
    public static function set($name, $value)
    {
        self::$data[$name] = $value;
    }
    
    public static function get($name)
    {
        if (isset(self::$data[$name])) 
        {
            return (object) self::$data[$name];
        }
        return (object) [
            'id' => -1,
            'first_name' => '',
            'last_name' => '',
            'email' => ''
        ];
    }
    
}