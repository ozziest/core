<?php namespace Ozziest\Core\Interfaces;

use Symfony\Component\HttpFoundation\Request;
use App\Core\Libraries\DB;

interface Middleware {
    
    public function exec(Request $request, DB $db);
    
}