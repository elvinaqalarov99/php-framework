<?php

namespace App\Models;

class Activity extends BaseModel
{
    public function __construct()
    {
        parent::__construct();

        $this->table = 'activities';
        $this->fillable = ['activity', 'participants', 'type', 'link'];
    }
}