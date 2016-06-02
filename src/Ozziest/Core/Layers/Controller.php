<?php namespace Ozziest\Core\Layers; 

use Ozziest\Windrider\Windrider;
use Ozziest\Core\Data\IDB;
use Ozziest\Core\Data\ISession;
use Ozziest\Core\System\ILogger;

class Controller {
    
    protected $session;
    protected $db;
    protected $logger;
    
    public function __construct(ISession $session, IDB $db, ILogger $logger)
    {
        $this->session = $session;
        $this->db = $db;
        $this->logger = $logger;
    }
    
}