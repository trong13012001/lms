<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use Haruncpi\LaravelUserActivity\Traits\Loggable;

class Role extends SpatieRole
{
    use Loggable;
}
