<?php

namespace App\Models;

use App\Filters\LogFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Log extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter(Builder $builder, $request)
    {
        return (new LogFilter($request))->filter($builder);
    }
}
