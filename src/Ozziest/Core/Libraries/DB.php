<?php namespace Ozziest\Core\Libraries;

use Illuminate\Database\Capsule\Manager as Capsule;
use IDB;

class DB implements IDB {

    private $capsule;

    public function connect()
    {
        $this->capsule = new Capsule; 
        $this->capsule->addConnection(array(
            'driver'    => 'mysql',
            'host'      => getenv('hostname'),
            'database'  => getenv('database'),
            'username'  => getenv('username'),
            'password'  => getenv('password'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => ''
        ));
        $this->capsule->bootEloquent();
             
    }

    public function transaction()
    {
        $this->capsule->getConnection()->beginTransaction();
    }

    public function commit()
    {
        $this->capsule->getConnection()->commit();
    }

    public function rollback()
    {
        $this->capsule->getConnection()->rollBack();
    }

    public function get()
    {
        return $this->capsule->getConnection();
    }

    public function query($sql, $arguments = array())
    {
        return $this->get()->select( $this->get()->raw($sql), $arguments);
    }    

}