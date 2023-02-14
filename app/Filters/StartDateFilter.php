<?php

namespace App\Filters;

class StartDateFilter
{
    public function filter($builder, $value)
    {
        return $builder->where('date', '>=', $value);
    }
}
