<?php namespace Ozziest\Core\Types; 

use App\Core\Libraries\Session;
use App\Core\Libraries\DB;
use App\Core\Libraries\Logger;
use Ozziest\Windrider\Windrider;

class Controller {
    
    protected $session;
    protected $db;
    protected $logger;
    
    public function __construct(Session $session, DB $db, Logger $logger)
    {
        $this->session = $session;
        $this->db = $db;
        $this->logger = $logger;
    }
    
}