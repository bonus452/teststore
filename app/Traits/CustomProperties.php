<?php

namespace App\Traits;

trait CustomProperties
{
    protected $customProperties = [];

    public function getCustomProp($key)
    {
        return $this->customProperties[$key] ?? null;
    }

    public function setCustomProp($key, $value)
    {
        $this->customProperties[$key] = $value;
        return $this;
    }
}
