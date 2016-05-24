<?php 

class FacadesTest extends PHPUnit_Framework_TestCase {

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