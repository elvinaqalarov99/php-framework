<?php

namespace App\Http\Controllers;

use App\Models\BaseModel;

abstract class BaseController
{
    protected BaseModel $model;

    protected function setModel(string $model): void
    {
        $this->model = new $model;
    }
}