<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;
use Haruncpi\LaravelUserActivity\Traits\Loggable;

class Permission extends SpatiePermission
{
    use Loggable;
}
