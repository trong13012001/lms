<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use eloquentFilter\QueryFilter\ModelFilters\Filterable;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use App\ModelFilters\CustomFilter;

class Tag extends Model
{

    use HasFactory,CustomFilter,     Filterable,Loggable;

    protected $fillable = [
        'name',
    ];

    public function books()
    {
        return $this->belongsToMany(Book::class,'book_tags','tag_id','book_id');
    }
}
