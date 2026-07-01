<?php

namespace App\Repositories;

use App\Enums\Priority;
use App\Models\TaskItem;

interface TaskRepositoryInterface
{
    public function getById(int $id): ?TaskItem;

    /**
     * @return TaskItem[]
     */
    public function getByOwner(int $ownerId, ?Priority $priority = null): array;

    public function save(TaskItem $task): TaskItem;

    public function update(TaskItem $task): ?TaskItem;

    public function delete(int $id): bool;
}
