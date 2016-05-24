<?php namespace Ozziest\Core\Facades;

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

class Router {

    private $parentNamespace = "";
    private $collection;
    private $currentMiddlewares = [];

    public function __construct()
    {
        $this->collection = new RouteCollection();   
    }
    
    public function setNamespace($parentNamespace)
    {
        $this->parentNamespace = $parentNamespace;
    }

    public function any($url, $controller, $action, $method = 'GET')
    {
        $controller = $this->parentNamespace."\\".$controller;
        $this->collection->add(
            str_replace('\\', '.', $controller).'.'.$action, // name of the route
            new Route( 
                $url, 
                ['controller' => $controller, 'method' => $action, 'middlewares' => $this->currentMiddlewares],
                [], // requirements
                [], // options
                '', // host
                [], // schemes
                [$method] // methods
            )
        );
    }

    public function get($url, $controller, $action)
    {
        $this->any($url, $controller, $action);
    }

    public function post($url, $controller, $action)
    {
        $this->any($url, $controller, $action, 'POST');
    }

    public function getCollection()
    {
        return $this->collection;
    }
    
    public function middleware($options, $function)
    {
        if (!is_array($options)) {
            $options = [$options];
        }
        $this->currentMiddlewares = $options;
        $function();
        $this->currentMiddlewares = [];
    }

}