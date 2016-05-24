<?php namespace Libraries;

use PHPUnit_Framework_TestCase;
use Mockery, Exception;
use Ozziest\Core\Libraries\Response;

class ResponseTest extends PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }

    public function testBlade()
    {
        $symfonyRequest = Mockery::mock('Symfony\Component\HttpFoundation\Request');
        
        $symfonyResponse = Mockery::mock('Symfony\Component\HttpFoundation\Response')
                                  ->shouldReceive('setContent')->times(1)
                                  ->shouldReceive('setStatusCode')->times(1)
                                  ->shouldReceive('prepare')->times(1)
                                  ->shouldReceive('setPublic')->times(1)
                                  ->shouldReceive('setMaxAge')->times(1)
                                  ->shouldReceive('send')->times(1)
                                  ->mock();
        
        $symfonyResponse->headers = Mockery::mock('headers')
                                           ->shouldReceive('set')->times(1)
                                           ->mock();
        
        $make = Mockery::mock('make')
                       ->shouldReceive('render')->times(1)
                       ->mock();
        
        $view = Mockery::mock('view')
                       ->shouldReceive('make')->with('welcome', [])->times(1)->andReturn($make)
                       ->mock();
        
        $blade = Mockery::mock('Philo\Blade\Blade')
                        ->shouldReceive('view')->times(1)->andReturn($view)
                        ->mock();
        
        $response = new Response($symfonyRequest, $symfonyResponse, $blade);
        
        $data = $response->view('welcome');
    }

    public function testJSON()
    {
        $symfonyRequest = Mockery::mock('Symfony\Component\HttpFoundation\Request');
        
        $symfonyResponse = Mockery::mock('Symfony\Component\HttpFoundation\Response')
                                  ->shouldReceive('setContent')->times(1)
                                  ->shouldReceive('setStatusCode')->times(1)
                                  ->shouldReceive('prepare')->times(1)
                                  ->shouldReceive('setPublic')->times(1)
                                  ->shouldReceive('setMaxAge')->times(1)
                                  ->shouldReceive('send')->times(1)
                                  ->mock();
        
        $symfonyResponse->headers = Mockery::mock('headers')
                                           ->shouldReceive('set')->with('Content-Type', 'application/json')->times(1)
                                           ->mock();

        $blade = Mockery::mock('Philo\Blade\Blade');

        $response = new Response($symfonyRequest, $symfonyResponse, $blade);
        
        $response->json([]);
    }

}