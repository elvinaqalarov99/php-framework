<?php

declare(strict_types=1);

namespace App\Services\API;

use App\Services\Http\BaseService;

class BoredAPIService extends BaseService
{
    public function __construct()
    {
        parent::__construct();

        $this->url('http://www.boredapi.com/api/activity/');
    }

    /**
     * Number of participants in the activity
     *
     * @param int $count
     * @return $this
     */
    public function participants(int $count): BoredAPIService
    {
        $this->query([
            'participants' => $count
        ]);

        return $this;
    }

    /**
     * Type of activity
     * Examples: 'social', 'education', 'recreational', 'relaxation', 'cooking', 'charity', 'busywork'
     *
     * @param string $type
     * @return $this
     */
    public function type(string $type): BoredAPIService
    {
        $this->query([
            'type' => $type
        ]);

        return $this;
    }
}