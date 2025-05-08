<?php

namespace App\ModelFilters;
use Illuminate\Database\Eloquent\Builder;
trait CustomFilter
{
    public function filterCustomName(Builder $builder, $value)
    {
        return $builder->where('name', 'REGEXP', $value);
    }
    public function filterCustomBook_code(Builder $builder, $value)
    {
        return $builder->where('book_code', 'REGEXP', $value);
    }
}
