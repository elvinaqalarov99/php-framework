<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\BaseModel;
use JsonException;

class ActivityController extends BaseController
{
    public function __construct()
    {
        $this->setModel(Activity::class);
    }

    /**
     * @return string
     * @throws JsonException
     */
    public function index(): string
    {
        return $this->model->list('id,activity,type,participants');
    }

    /**
     * @param int $id
     * @return string
     * @throws JsonException
     */
    public function show(int $id): string
    {
        return $this->model->getById($id, 'id,activity,type,participants');
    }
}