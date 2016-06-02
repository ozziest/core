<?php namespace Ozziest\Core\Data;

interface IDB {
    
    public function connect();
    
    public function transaction();
    
    public function commit();
    
    public function rollback();
    
    public function get();
    
    public function query($sql, $arguments = array());
    
}