<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use eloquentFilter\QueryFilter\ModelFilters\Filterable;
use Haruncpi\LaravelUserActivity\Traits\Loggable;

class Setting extends Model
{
    use HasFactory, Filterable,Loggable;

    protected $fillable = [
        'key',
        'value'
    ];

}
