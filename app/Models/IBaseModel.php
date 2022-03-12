<?php

namespace App\Models;

interface IBaseModel
{
    /**
     * @param string $columns
     * @return array
     */
    public function list(string $columns = '*'): array;

    /**
     * @param array $data
     * @return mixed
     */
    public function insert(array $data = []): void;
}