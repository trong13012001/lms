<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use eloquentFilter\QueryFilter\ModelFilters\Filterable;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use App\ModelFilters\CustomFilter;

class Customer extends Model
{
    use HasFactory,CustomFilter, Filterable,Loggable;

    protected $fillable = [
        'customer_id',
        'name',
        'email',
        'phone',
        'address',
    ];

    public function issuedBooks()
    {
        return $this->hasMany(IssuedBook::class,'customer_id','id');
    }
}
