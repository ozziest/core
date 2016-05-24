<?php 

use Ahir\Facades\Facade;

class DI extends Facade {

    /**
     * Get the connector name of main class
     *
     * @return string
     */
    public static function getFacadeAccessor() 
    { 
        return 'Ozziest\Core\Facades\DI';
    }

}