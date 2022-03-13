<?php

namespace App\Core\Traits;

use JetBrains\PhpStorm\ArrayShape;

trait SanitizesData
{
    /**
     * @param array $data
     * @return void
     */
    protected function sanitizeData(array &$data = []): void
    {
        foreach ($data as $column => $value) {
            if (empty($value)) {
                if (is_string($value)) {
                    $data[$column ] = null;
                } elseif (is_int($value)) {
                    $data[$column ] = 0;
                }
            }
        }
    }

    /**
     * @param array $data
     * @return array
     */
    protected function filterData(array &$data = []): array
    {
        foreach ($data as $column => $value) {
            if (!in_array($column, $this->fillable, true)) {
                unset($data[$column]);
            }
        }

        $data['updated_at'] = date('Y-m-d H:i:s');

        return $data;
    }

    /**
     * @param $data
     * @return array
     */
    #[ArrayShape(['columns' => "string", 'prepare' => "string", 'values' => "array"])]
    protected function prepareData($data): array
    {
        $columns = implode(',', array_keys($data)) ?? '';
        $values  = array_values($data) ?? [];
        $prepare = implode(',', array_fill(0, count($data), '?')) ?? '';

        return [
            'columns' => $columns,
            'prepare' => $prepare,
            'values' => $values,
        ];
    }
}