<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use eloquentFilter\QueryFilter\ModelFilters\Filterable;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use App\ModelFilters\CustomFilter;

class BookItem extends Model
{
    use HasFactory, Filterable, Loggable,CustomFilter;

    protected $fillable = [
        'book_id',
        'publisher_id',
        'book_code',
        'location',
        'published_at'

    ];
    private static $whiteListFilter = ['*', 'book_code'];


    public function book()
    {
        return $this->belongsTo(Book::class,'book_id','id');
    }
    public function issuedBooks()
    {
        return $this->hasMany(IssuedBook::class,'book_item_id','id');
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class,'publisher_id','id');
    }

}
