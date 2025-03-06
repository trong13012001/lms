<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use eloquentFilter\QueryFilter\ModelFilters\Filterable;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use App\ModelFilters\CustomFilter;

class Genre extends Model
{
    use HasFactory,CustomFilter, Filterable,Loggable;

    protected $fillable = [
        'name',
        'description',
        'image'
    ];

    public function books()
    {
        return $this->belongsToMany(Book::class,'book_genres','genre_id','book_id');
    }
}
