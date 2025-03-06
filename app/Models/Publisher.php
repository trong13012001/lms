<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use eloquentFilter\QueryFilter\ModelFilters\Filterable;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use App\ModelFilters\CustomFilter;

class Publisher extends Model
{
    use HasFactory,CustomFilter, Filterable,Loggable;

    protected $fillable = [
        'name',
        'description',
        'image'
    ];

    public function bookItems()
    {
        return $this->hasMany(BookItem::class,'publisher_id','id');
    }

}
