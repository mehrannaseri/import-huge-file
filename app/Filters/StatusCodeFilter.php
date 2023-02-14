<?php

namespace App\Filters;

class StatusCodeFilter
{
    public function filter($builder, $value)
    {
        return $builder->where('status_code', $value);
    }
}
