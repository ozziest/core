<?php namespace Ozziest\Core\HTTP;

interface IRouter {
    
    public function setNamespace($parentNamespace);
    
    public function any($url, $controller, $action, $method = 'GET');
    
    public function get($url, $controller, $action);
    
    public function post($url, $controller, $action);
    
    public function getCollection();
    
    public function middleware($options, $function);

}