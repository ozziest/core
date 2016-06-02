<?php namespace Ozziest\Core\Data;

interface ISession {
    
    public function id();
    
    public function name();
    
    public function email();
    
    public function get();
    
}