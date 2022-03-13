<?php

namespace App\Models;

use App\Core\Database;
use App\Core\Traits\SanitizesData;

class BaseModel implements IBaseModel
{
    use SanitizesData;

    protected Database $db;
    protected string $table = '';
    protected array $fillable = [];

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * @param string $columns
     * @return array
     */
    public function list(string $columns = '*'): array
    {
        $query = $this->db->query("SELECT $columns FROM $this->table WHERE deleted_at IS NULL");

        return $query->fetchAll();
    }

    /**
     * todo Refactor data flow
     * @param array $data
     * @return void
     */
    public function insert(array $data = []): void
    {
        $this->sanitizeData($data);
        $this->filterData($data);
        $prepared = $this->prepareData($data);

        $this->db->query("INSERT INTO $this->table ({$prepared['columns']}) VALUES ({$prepared['prepare']})", ...$prepared['values']);
    }
}