<?php namespace Ozziest\Core\System;

class DIManager {
    
    public function model($name)
    {
        $name = 'App\Models\\'.$name;
        return new $name();
    }
    
}