<?php namespace Ozziest\Core\Interfaces;

use Symfony\Component\HttpFoundation\Request;
use Ozziest\Core\Libraries\DB;

interface Middleware {
    
    public function exec(Request $request, DB $db);
    
}