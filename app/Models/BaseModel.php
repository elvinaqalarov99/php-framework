<?php

namespace App\Models;

use App\Core\Database;
use App\Core\Traits\HandlesData;
use JsonException;

class BaseModel implements IBaseModel
{
    use HandlesData;

    protected Database $db;
    protected string $table = '';
    protected array $fillable = [];

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * @param string $columns
     * @return string
     * @throws JsonException
     */
    public function list(string $columns = '*'): string
    {
        $query = $this->db->query("SELECT $columns FROM $this->table WHERE deleted_at IS NULL");

        return json_encode($query->fetchAll(), JSON_THROW_ON_ERROR);
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

    /**
     * @param int $id
     * @param string $columns
     * @return bool|string
     * @throws JsonException
     */
    public function getById(int $id, string $columns = '*'): bool|string
    {
        $query = $this->db->query("SELECT $columns FROM $this->table WHERE id = ? AND deleted_at IS NULL", $id);

        return json_encode($query->fetchArray(), JSON_THROW_ON_ERROR);
    }
}