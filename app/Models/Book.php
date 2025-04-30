<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use eloquentFilter\QueryFilter\ModelFilters\Filterable;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use App\ModelFilters\CustomFilter;


class Book extends Model
{
    use HasFactory,CustomFilter, Filterable,Loggable;
    protected $fillable = [
        'name',
        'description',
        'image',
        'published_on',
    ];
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'book_tags', 'book_id', 'tag_id');
    }
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'book_genres', 'book_id', 'genre_id');
    }
    public function items()
    {
        return $this->hasMany(BookItem::class,'book_id','id');
    }
    public function authors()
    {
        return $this->belongsToMany(Author::class,'book_authors','book_id','author_id');
    }

}
