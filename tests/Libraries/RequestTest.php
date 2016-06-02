<?php namespace Libraries;

use PHPUnit_Framework_TestCase;
use Mockery, Exception;
use Ozziest\Core\HTTP\Request;

class RequestTest extends PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }

    public function testInit()
    {
        $subRequest = Mockery::mock('subRequest')
                             ->shouldReceive('all')->times(1)
                             ->shouldReceive('get')->with('name')->times(1)->andReturn('Foo Bar')
                             ->mock();
        
        $symfony = Mockery::mock('Symfony\Component\HttpFoundation\Request');
        $symfony->parameters = ['id' => 666];
        $symfony->request = $subRequest;

        $request = new Request($symfony);
        $this->assertEquals($request->getUrlParam('id'), 666);
        $this->assertEquals($request->getUrlParam('salary', 1000), 1000);
        
        $request->all();
        $this->assertEquals($request->get('name'), 'Foo Bar');
    }

}