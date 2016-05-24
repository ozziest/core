<?php namespace Ozziest\Core\Facades;

use Exception;

class DI {

    private $list = [];
    
    public function register($name, $callback)
    {
        $this->list[$name] = $callback;
    }
    
    public function resolve($name)
    {
        if (isset($this->list[$name])) 
        {
            // Bu değişlen bağımlılık tanımlaması bir fonksiyon mu?
            if (is_callable($this->list[$name]))
            {
                return $this->list[$name]();                
            }
            // Bu bir fonksiyon değilse diğerini gönder.
            return $this->list[$name];
        }
        throw new Exception("Dependecy not found: {$name}");
    }
    
}