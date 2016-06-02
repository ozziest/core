<?php namespace Ozziest\Core\Data;

use Ozziest\Core\HTTP\IRequest;

class Paginate implements IPaginate {

    public static function get($query, IRequest $request)
    {
        $total = $query->count();
        return (object) [
            'data'    => $query->take(10)->skip($request->getUrlParam('skip'))->get(),
            'total'   => $total,
            'pages'   => ceil($total / 10),
            'current' => (int) $request->getUrlParam('skip')
        ];
    }
    
}