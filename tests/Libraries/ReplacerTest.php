<?php namespace Libraries;

use PHPUnit_Framework_TestCase;
use Mockery, Exception;
use Ozziest\Core\Libraries\Replacer;

class ReplacerTest extends PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }

    public function testInit()
    {
        $content = new Replacer("Hello {NAME}!");
        $content->replace('NAME', 'Foo Bar');
        $this->assertEquals($content->toString(), 'Hello Foo Bar!');
    }

}