<?php

namespace App\Filters;

class ServiceNameFilter
{
    public function filter($builder, $value)
    {
        return $builder->where('service_name', 'like', "%$value%");
    }
}
