<?php namespace Ozziest\Core\Facades;

use Ozziest\Core\Exceptions\UserException;

class Statics {

    private $list = [];
    
    public function set($key, $values)
    {
        $this->list[$key] = $values;
    }
    
    public function check($key, $value)
    {
        if (in_array($value, $this->list[$key]) === false)
        {
            throw new UserException("The {$key} is invalid!");
        }
    }
   
}