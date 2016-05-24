<?php 

use Ahir\Facades\Facade;

class Statics extends Facade {

    /**
     * Get the connector name of main class
     *
     * @return string
     */
    public static function getFacadeAccessor() 
    { 
        return 'App\Core\Facades\Statics';
    }

}