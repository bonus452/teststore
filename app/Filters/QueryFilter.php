<?php

namespace App\Filters;


use Illuminate\Database\Eloquent\Builder;

class QueryFilter
{
    protected $builder;

    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;
        foreach (request()->input() as $input => $value) {
            if (method_exists($this, $input)) {
                call_user_func([$this, $input], (array)$value);
            }
        }
        return $this->builder;
    }
}
