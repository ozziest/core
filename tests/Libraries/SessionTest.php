<?php namespace Libraries;

use PHPUnit_Framework_TestCase;
use Mockery, Exception;
use Ozziest\Core\Libraries\Session;

class SessionTest extends PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }

    public function testBlade()
    {
        $session = new Session();
    }

}