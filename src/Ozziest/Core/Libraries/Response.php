<?php namespace Ozziest\Core\Libraries;

use Philo\Blade\Blade;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use IResponse;

class Response implements IResponse {

    private $engine;
    private $request;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->engine = new Blade(ROOT.'resource/views', ROOT.'resource/cache');
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
        $response = new SymfonyResponse(
            $content, 
            $status,
            array('content-type' => $type)
        );
        $response->prepare($this->request);
        $response->setPublic();
        $response->setMaxAge(600);
        $response->send();
    }

    private function get($name, $arguments = [])
    {
        return $this->engine->view()->make($name, $arguments)->render();
    }

}