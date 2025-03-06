<?php

namespace App\ModelFilters;
use Illuminate\Database\Eloquent\Builder;
trait CustomFilter
{
    public function filterCustomName(Builder $builder, $value)
    {
        if (isset($value['search'])) {
            $builder->where('name', 'like', '%' . $value['search'] . '%');
        }

        if (isset($value['regex'])) {
            $builder->where('name', 'REGEXP', $value['regex']);
        }

        return $builder;
    }
    public function filterCustomBookCode(Builder $builder, $value)
    {
        if (isset($value['search'])) {
            $builder->where('book_code', 'like', '%' . $value['search'] . '%');
        }

        if (isset($value['regex'])) {
            $builder->where('book_code', 'REGEXP', $value['regex']);
        }

        return $builder;
    }
}
