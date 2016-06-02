<?php 

use Ozziest\Core\HTTP\Router;

class FacadesTest extends PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
        putenv("app_key=my_secret_key");
    }

    public function testLifeCycle()
    {
        $data = Lifecycle::get('my_data');
        $this->assertEquals($data->id, -1);
        
        Lifecycle::set('my_data', [
            'id' => 666
        ]);

        $data = Lifecycle::get('my_data');
        $this->assertEquals($data->id, 666);
    }
    
    public function testStatics()
    {
        Statics::set('Period', [1, 2, 5, 10, 15, 30, 45, 60, 90, 120]);
        Statics::check('Period', 1);
        Statics::check('Period', 2);
        Statics::check('Period', 5);
        Statics::check('Period', 10);
        Statics::check('Period', 120);
    }

    /**
     * @expectedException Ozziest\Core\Exceptions\UserException
     * @expectedExceptionMessage The Period is invalid!
     */
    public function testStaticsException()
    {
        Statics::check('Period', 666);
    }

}