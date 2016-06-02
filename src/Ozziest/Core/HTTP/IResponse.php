<?php namespace Ozziest\Core\HTTP;

interface IResponse {
    
    public function view($name, $arguments = [], $status = 200);
    
    public function json($data, $status = 200);
    
    public function ok();
    
}