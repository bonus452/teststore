<?php

namespace App\Repository\Breadcrumbs;

use Illuminate\Database\Eloquent\Model;

abstract class CoreBreadcrumb
{
    protected $instance;
    public function __construct()
    {
        $this->instance = app($this->getClassName());
    }

    protected function getInstance(){
        return $this->instance;
    }

    abstract protected function getClassName() :string;
    abstract function getBreadcrumb(Model $model);
}
