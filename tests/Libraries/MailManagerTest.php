<?php namespace Libraries;

use PHPUnit_Framework_TestCase;
use Mockery, Exception;
use Ozziest\Core\Libraries\MailManager;

class MailManagerTest extends PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }

    public function testInit()
    {
        $mailer = Mockery::mock('Nette\Mail\SmtpMailer')
                         ->shouldReceive('send')->with('Nette\Mail\Message')->times(1)
                         ->mock();
        
        $setSubject = Mockery::mock('setSubject')
                             ->shouldReceive('setHTMLBody')->with('testing')->times(1)
                             ->mock();
        
        $addTo = Mockery::mock('addTo')
                        ->shouldReceive('setSubject')->with('Welcome')->times(1)->andReturn($setSubject)
                        ->mock();
        
        $message = Mockery::mock('Nette\Mail\Message')
                          ->shouldReceive('setFrom')->times(1)
                          ->shouldReceive('addTo')->with('foo@bar.com')->times(1)->andReturn($addTo)
                          ->mock();
        
        $manager = new MailManager($mailer, $message);
        $manager->welcome('foo@bar.com', 'Foo Bar');
    }

}