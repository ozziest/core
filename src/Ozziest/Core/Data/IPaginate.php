<?php namespace Ozziest\Core\Data;

use Ozziest\Core\HTTP\IRequest;

interface IPaginate {
    
    public static function get($query, IRequest $request);
    
}