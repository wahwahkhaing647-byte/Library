<?php

namespace App\Contract;

interface BaseInterface
{
    // Create
    public function create(array $data): int;

    // Read
    public function findById(int $id);

    public function findAll(int $limit = null, int $offset = 0): array;

    public function count(array $filters = []): int;

    // Update
    public function update(int $id, array $data): bool;

    // Delete
    public function delete(int $id): bool;
}