<?php

namespace App\Filters;


use Illuminate\Database\Eloquent\Builder;

class QueryFilter
{

    protected $builder;

    public function apply(Builder $builder){
        $this->builder = $builder;

        foreach (request()->all() as $input => $value){
            if (method_exists($this, $input)){
                call_user_func([$this, $input], (array)$value);
            }
        }

    }
}
