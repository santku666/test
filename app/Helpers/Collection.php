<?php

namespace App\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as BaseCollection; # laravels original collection class

class Collection extends BaseCollection # my custom collection class inherit laravels collection classs
{
    public function paginate($perPage, $total = null, $page = null, $pageName = 'page')
    {
        $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
      
        return new LengthAwarePaginator(
            $this->forPage($page, $perPage),
            $total ?: $this->count(),
            $perPage,
            $page,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'pageName' => $pageName,
            ]
        );
    }
}