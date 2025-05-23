<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use eloquentFilter\QueryFilter\ModelFilters\Filterable;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use App\ModelFilters\CustomFilter;

class IssuedBook extends Model
{
    use HasFactory, Filterable,Loggable,CustomFilter;

    protected $fillable = [
        'book_item_id',
        'user_id',
        'customer_id',
        'issued_date',
        'return_date',
        'returned_date',
        'status'

    ];

    public function bookItem()
    {
        return $this->belongsTo(BookItem::class,'book_item_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id','id');;
    }

}
