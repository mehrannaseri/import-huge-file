<?php

namespace App\Filters;

class LogFilter extends AbstractFilter
{
    protected $filters = [
        'status_code' => StatusCodeFilter::class,
        'service_name' => ServiceNameFilter::class,
        'start_date' => StartDateFilter::class,
        'end_date' => EndDateFilter::class,
    ];
}
