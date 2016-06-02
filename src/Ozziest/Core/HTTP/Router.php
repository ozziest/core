<?php namespace Ozziest\Core\HTTP;

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

class Router implements IRouter {

    private static $parentNamespace = "";
    private static $collection;
    private static $currentMiddlewares = [];

    public function setNamespace($parentNamespace)
    {
        self::createFirst();
        self::$parentNamespace = $parentNamespace;
    }

    public function any($url, $controller, $action, $method = 'GET')
    {
        self::createFirst();
        $controller = self::$parentNamespace."\\".$controller;
        self::$collection->add(
            str_replace('\\', '.', $controller).'.'.$action, // name of the route
            new Route( 
                $url, 
                ['controller' => $controller, 'method' => $action, 'middlewares' => self::$currentMiddlewares],
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
        self::any($url, $controller, $action);
    }

    public function post($url, $controller, $action)
    {
        self::any($url, $controller, $action, 'POST');
    }

    public function getCollection()
    {
        self::createFirst();
        return self::$collection;
    }
    
    public function middleware($options, $function)
    {
        self::createFirst();
        
        if (!is_array($options)) 
        {
            $options = [$options];
        }
        
        self::$currentMiddlewares = $options;
        $function();
        self::$currentMiddlewares = [];
    }
    
    private static function createFirst()
    {
        if (isset(self::$collection) === false)
        {
            self::$collection = new RouteCollection();
        }
    }

}