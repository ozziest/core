<?php namespace Libraries;

use PHPUnit_Framework_TestCase;
use Mockery, Exception;
use Ozziest\Core\Libraries\Request;

class RequestTest extends PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }

    public function testInit()
    {
        $subRequest = Mockery::mock('subRequest');
        
        $symfony = Mockery::mock('Symfony\Component\HttpFoundation\Request');
        $symfony->parameters = ['id' => 666];

        $request = new Request($symfony);
        $this->assertEquals($request->getUrlParam('id'), 666);
    }

}