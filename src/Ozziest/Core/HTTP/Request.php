<?php namespace Ozziest\Core\HTTP;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class Request implements IRequest {

    private $params;
    private $symfony;
    
    public function __construct(SymfonyRequest $request)
    {
        $this->symfony = $request;
        $this->params = $request->request;
    }
    
    public function getUrlParam($key, $default = null)
    {
        if (isset($this->symfony->parameters[$key]))
        {
            $default = $this->symfony->parameters[$key];
        }
        return $default;
    }

    public function all()
    {
        return $this->params->all();
    }

    public function get($name, $default = null)
    {
        try {
            $default = $this->params->get($name);
        }
        catch (Exception $exception) {
            
        }
        return $default;
    }    

}