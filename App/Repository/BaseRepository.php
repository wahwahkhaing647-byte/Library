<?php

declare(strict_types=1);

namespace App\Repository;

use App\Contract\BaseInterface;
use PDO;

/**
 * Generic BaseRepository
 * Provides full CRUD for all models
 */
abstract class BaseRepository implements BaseInterface
{
    protected PDO $db;

    protected string $table;

    protected string $primaryKey = 'id';

    // IMPORTANT: child class must define this
    protected array $fillable = [];

    public function __construct(PDO $db)
    {
        $this->db = $db;

        // IMPORTANT: make PDO throw exceptions
        $this->db->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );
    }

    /*
    |--------------------------------------------------------------------------
    | FIND ALL
    |--------------------------------------------------------------------------
    */

    public function findAll(int $limit = null, int $offset = 0): array
{
    $sql = "SELECT * FROM {$this->table}";

    if ($limit !== null) {
        $sql .= " LIMIT :limit OFFSET :offset";
    }

    $stmt = $this->db->prepare($sql);

    if ($limit !== null) {
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    }

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC); // ONLY RAW DATA
}
    /*
    |--------------------------------------------------------------------------
    | FIND BY ID
    |--------------------------------------------------------------------------
    */

  public function findById(int $id): ?array
{
    $stmt = $this->db->prepare("
        SELECT * FROM {$this->table}
        WHERE {$this->primaryKey} = :id
    ");

    $stmt->execute([':id' => $id]);

    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

    /*
    |--------------------------------------------------------------------------
    | COUNT
    |--------------------------------------------------------------------------
    */

    public function count(array $filters = []): int
    {
        $stmt = $this->db->query("
            SELECT COUNT(*)
            FROM {$this->table}
        ");

        return (int) $stmt->fetchColumn();
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE (FULL CRUD)
    |--------------------------------------------------------------------------
    */

    public function create(array $data): int
    {
        $fields = [];
        $placeholders = [];
        $values = [];

        foreach ($this->fillable as $column) {

            if (array_key_exists($column, $data)) {

                $fields[] = $column;
                $placeholders[] = ':' . $column;
                $values[':' . $column] = $data[$column];
            }
        }

        if (empty($fields)) {
            throw new \Exception("No valid data provided for insert.");
        }

        $sql = "INSERT INTO {$this->table}
                (" . implode(',', $fields) . ")
                VALUES (" . implode(',', $placeholders) . ")";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($values);

        return (int) $this->db->lastInsertId();
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE (FULL CRUD)
    |--------------------------------------------------------------------------
    */

    public function update(int $id, array $data): bool
    {
        $sets = [];
        $values = [];

        foreach ($this->fillable as $column) {

            if (array_key_exists($column, $data)) {

                $sets[] = "$column = :$column";
                $values[":$column"] = $data[$column];
            }
        }

        if (empty($sets)) {
            throw new \Exception("No valid data provided for update.");
        }

        $values[':id'] = $id;

        $sql = "UPDATE {$this->table}
                SET " . implode(', ', $sets) . "
                WHERE {$this->primaryKey} = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute($values);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE (FULL CRUD)
    |--------------------------------------------------------------------------
    */

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table}
                WHERE {$this->primaryKey} = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }
}