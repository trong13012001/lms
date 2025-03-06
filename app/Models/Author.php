<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use eloquentFilter\QueryFilter\ModelFilters\Filterable;
use App\ModelFilters\CustomFilter;
use Haruncpi\LaravelUserActivity\Traits\Loggable;



class Author extends Model
{
    use HasFactory,CustomFilter, Filterable,Loggable;

    protected $fillable = [
        'name',
        'description',
        'image'
    ];

    public function books()
    {
        return $this->belongsToMany(Book::class,'book_authors','author_id','book_id');
    }
}
