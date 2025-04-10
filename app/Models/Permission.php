<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use eloquentFilter\QueryFilter\ModelFilters\Filterable;
use App\ModelFilters\CustomFilter;

class Permission extends SpatiePermission
{
    use Loggable,Loggable,CustomFilter;
    private static $whiteListFilter=['*'];
}
