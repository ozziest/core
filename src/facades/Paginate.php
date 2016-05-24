<?php 

use Ahir\Facades\Facade;

class Paginate extends Facade {

    /**
     * Get the connector name of main class
     *
     * @return string
     */
    public static function getFacadeAccessor() 
    { 
        return 'App\Core\Facades\Paginate';
    }

}