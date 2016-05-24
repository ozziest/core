<?php namespace Ozziest\Core\Facades;

use IRequest;

class Paginate {

    public function get($query, IRequest $request)
    {
        $total = $query->count();
        return [
            'data'    => $query->take(10)->skip($request->getUrlParam('skip'))->get(),
            'total'   => $total,
            'pages'   => ceil($total / 10),
            'current' => (int) $request->getUrlParam('skip')
        ];
    }
    
}