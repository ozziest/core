<?php 

class FacadesTest extends PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
        putenv("app_key=my_secret_key");
    }

    public function testDI()
    {
        DI::register('name', function () {
           return 'di_tester';
        });
        $this->assertEquals(DI::resolve('name'), 'di_tester');

        DI::register('value_name', 'value');
        $this->assertEquals(DI::resolve('value_name'), 'value');
    }
    
    /**
     * @expectedException Exception
     */
    public function testDIException()
    {
        $this->assertEquals(DI::resolve('undefined_name'), 'undefined_value');
    }

    public function testHelper()
    {
        $this->assertTrue(Helper::hash('value') !== 'value');
        $this->assertTrue(Helper::getToken() !== Helper::getToken());
        
        $value = (new DateTime())->add(new DateInterval('PT30M'))->format('Y-m-d H:i:s');
        $this->assertTrue(Helper::getExpiredDate() == $value);
        
        $this->assertTrue(strlen(Helper::randomString()) === 10);
        
        $this->assertEquals(Helper::ip(), 'UNKNOWN');
        
        $_SERVER["HTTP_USER_AGENT"] = 'chrome';
        $this->assertEquals(Helper::agentClear(), 'chrome');
        $this->assertEquals(Helper::agent(), md5('chrome'));
        
        $this->assertTrue(Helper::salt('foo1@bar.com', '123456') !== Helper::salt('foo2@bar.com', '123456'));

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
    
    /**
     * @dataProvider paginateProvider
     */
    public function testPaginate($total, $current)
    {
        $skip = Mockery::mock('skip')
                       ->shouldReceive('get')
                       ->andReturn([
                           ['id' => 1, 'name' => 'John']
                         ])
                       ->mock();
        
        $take = Mockery::mock('take')
                       ->shouldReceive('skip')
                       ->andReturn($skip)
                       ->mock();
        
        $query = Mockery::mock('foo')
                        ->shouldReceive('count')
                        ->andReturn($total)
                        ->shouldReceive('take')
                        ->andReturn($take)
                        ->mock();

        $request = Mockery::mock('IRequest')
                          ->shouldReceive('getUrlParam')
                          ->andReturn($current)
                          ->mock();
        
        $data =  Paginate::get($query, $request);

        $this->assertEquals($data['total'], $total);
        $this->assertEquals($data['pages'], ceil($total / 10));
        $this->assertEquals($data['current'], $current);
        $this->assertEquals(count($data['data']), 1);
    }
    
    /**
     * @dataProvider routerProvider
     */
    public function testRouter($method, $url, $controller, $action)
    {
        Router::setNamespace('App\Controllers');
        Router::any($url, $controller, $action, strtoupper($method));
    }
    
    public function testRouteCollection()
    {
        $collection = Router::getCollection();
        $this->assertInstanceOf('Symfony\Component\Routing\RouteCollection', $collection);
        $this->assertEquals($collection->count(), 2);
        foreach ($collection->all() as $key => $route)
        {
            $this->assertInstanceOf('Symfony\Component\Routing\Route', $route);
        }
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

    public function routerProvider()
    {
        return array(
            // url, controller, action
            array('get', 'users', 'Users', 'getAll'),
            array('post', 'users/create', 'Users', 'create'),
        );
    }      
    
    public function paginateProvider()
    {
        return array(
            // total, skip
            array(10, 1),
            array(100, 1),
            array(78, 1),
            array(158, 2),
        );
    }      

}