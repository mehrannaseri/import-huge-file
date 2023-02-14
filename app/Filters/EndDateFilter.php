<?php

namespace App\Filters;

class EndDateFilter
{
    public function filter($builder, $value)
    {
        return $builder->where('date', '<=', $value);
    }
}
