<?php namespace Ozziest\Core\Libraries;

use IRepository, IDB;

class Repository implements IRepository {
    
    protected $db;
    
    public function __construct(IDB $db)
    {
        $this->db = $db;
    }
    
}