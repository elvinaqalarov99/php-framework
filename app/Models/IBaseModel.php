<?php

namespace App\Models;

interface IBaseModel
{
    /**
     * @param string $columns
     * @return string
     */
    public function list(string $columns = '*'): string;

    /**
     * @param array $data
     * @return void
     */
    public function insert(array $data = []): void;
}