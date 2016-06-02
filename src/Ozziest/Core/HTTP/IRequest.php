<?php namespace Ozziest\Core\HTTP;

interface IRequest {
    
    public function getUrlParam($key, $default = null);
    
    public function all();
    
    public function get($name, $default = null);
    
}