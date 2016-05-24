<?php namespace Ozziest\Core\Facades;

class Lifecycle {

    private $data = [];
    
    public function set($name, $value)
    {
        $this->data[$name] = $value;
    }
    
    public function get($name)
    {
        if (isset($this->data[$name])) 
        {
            return (object) $this->data[$name];
        }
        return (object) [
            'id' => -1,
            'first_name' => '',
            'last_name' => '',
            'email' => ''
        ];
    }
    
}