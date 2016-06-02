<?php namespace Ozziest\Core\HTTP;

use Philo\Blade\Blade;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class Response implements IResponse {

    private $engine;
    private $request;
    
    public function __construct(SymfonyRequest $request, SymfonyResponse $response, Blade $blade)
    {
        $this->request  = $request;
        $this->response = $response;
        $this->engine   = $blade;
    }
    
    public function view($name, $arguments = [], $status = 200)
    {
        $content = $this->get($name, $arguments);
        $this->putResponse($content, $status, 'text/html');
    }
    
    public function json($data, $status = 200)
    {
        $content = json_encode($data);
        $this->putResponse($content, $status, 'application/json');
    }
    
    public function ok()
    {
        $this->putResponse("", 200, 'application/json');
    }
    
    private function putResponse($content, $status, $type)
    {
        $this->response->setContent($content);
        $this->response->setStatusCode($status);
        $this->response->headers->set('Content-Type', $type);
        $this->response->prepare($this->request);
        $this->response->setPublic();
        $this->response->setMaxAge(600);
        $this->response->send();
    }

    private function get($name, $arguments = [])
    {
        return $this->engine->view()->make($name, $arguments)->render();
    }

}