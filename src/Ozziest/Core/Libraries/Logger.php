<?php namespace Ozziest\Core\Libraries;

use Monolog\Logger as MonoLogger;
use Monolog\Handler\StreamHandler;
use DateTime;

class Logger {
    
    private $logger;
    
    public function __construct(MonoLogger $logger)
    {
        $this->logger = $logger;
        $file = (new DateTime())->format('Y-m-d').'.log';
        $this->logger->pushHandler(new StreamHandler(ROOT.'resource/logs/'.$file, MonoLogger::WARNING));
    }
    
    public function error($message)
    {
        $this->logger->addError($message);        
    }

    public function warning($message)
    {
        $this->logger->addWarning($message);        
    }
    
    public function exception($exception)
    {
        $this->logger->addError(
            '['.$exception->getCode().'] '.$exception->getMessage()."\n".
            $exception->getFile().": ".$exception->getLine()."\n".
            $exception->getTraceAsString()
        );
    }
    
}