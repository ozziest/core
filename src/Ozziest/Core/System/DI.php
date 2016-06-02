<?php namespace Ozziest\Core\System;

use Exception;

class DI {
    
    private static $manager;
    
    public static function setManager($manager)
    {
        self::$manager = $manager;
    }
    
    public static function model($name)
    {
        self::check();
        return self::$manager->model($name);
    }
    
    private static function check()
    {
        if (isset(self::$manager) === false)
        {
            throw new Exception("DI Manager has not been set!");
        }
    }
    
}