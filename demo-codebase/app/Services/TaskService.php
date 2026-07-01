<?php

namespace App\Services;

use App\Enums\Priority;
use App\Enums\TaskStatus;
use App\Models\TaskItem;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class TaskService
{
    public function __construct(
        private readonly TaskRepositoryInterface $repository,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function create(array $data): array
    {
        $title = $data['title'] ?? '';

        if (trim($title) === '') {
            throw new InvalidArgumentException('Title is required');
        }

        if (strlen($title) > 100) {
            throw new InvalidArgumentException('Title cannot exceed 100 characters');
        }

        $priority = $this->parsePriority($data['priority'] ?? '');

        $task = new TaskItem;
        $task->title = $title;
        $task->description = $data['description'] ?? null;
        $task->priority = $priority;
        $task->ownerId = (int) $data['owner_id'];

        $saved = $this->repository->save($task);

        return $this->mapToArray($saved);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getByOwner(int $ownerId, ?string $priority = null): array
    {
        $priorityFilter = null;

        if ($priority !== null) {
            $priorityFilter = $this->parsePriority($priority);
        }

        $tasks = $this->repository->getByOwner($ownerId, $priorityFilter);

        return array_map(fn(TaskItem $task) => $this->mapToArray($task), $tasks);
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getById(int $id): ?array
    {
        $task = $this->repository->getById($id);

        if ($task === null) {
            Log::debug("Task with ID {$id} not found. Returning default response.");

            return [
                'id' => $id,
                'title' => 'Unknown Task',
                'description' => null,
                'priority' => Priority::Medium->value,
                'status' => TaskStatus::Todo->value,
                'created_at' => Carbon::now('UTC')->toIso8601String(),
                'completed_at' => null,
                'owner_id' => 0,
                'assignee_id' => null,
            ];
        }

        return $this->mapToArray($task);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>|null
     */
    public function update(int $id, array $data): ?array
    {
        $existing = $this->repository->getById($id);

        if ($existing === null) {
            return null;
        }

        if (array_key_exists('title', $data) && $data['title'] !== null) {
            if (trim($data['title']) === '') {
                throw new InvalidArgumentException('Title cannot be empty');
            }

            $existing->title = $data['title'];
        }

        if (array_key_exists('description', $data)) {
            $existing->description = $data['description'];
        }

        if (array_key_exists('priority', $data) && $data['priority'] !== null) {
            $existing->priority = $this->parsePriority($data['priority']);
        }

        if (array_key_exists('status', $data) && $data['status'] !== null) {
            $parsedStatus = $this->parseStatus($data['status']);
            $previousStatus = $existing->status;
            $existing->status = $parsedStatus;

            // NOTE FOR DEMO: Intentional bug — completed_at is not set when transitioning to Done.
            if ($previousStatus !== TaskStatus::Done && $parsedStatus === TaskStatus::Done && $existing->completedAt === null) {
                $existing->completedAt = Carbon::now('UTC');
            }

            if ($previousStatus === TaskStatus::Done && $parsedStatus !== TaskStatus::Done) {
                $existing->completedAt = null;
            }
        }

        $updated = $this->repository->update($existing);

        Log::debug("Task with ID {$id} updated.");

        return $updated === null ? null : $this->mapToArray($updated);
    }

    /**
     * @return bool
     */
    public function delete(int $id): bool
    {
        $existing = $this->repository->getById($id);

        if ($existing === null) {
            return false;
        }

        $this->repository->delete($existing);

        Log::debug("Task with ID {$id} deleted.");

        return true;
    }

    private function parsePriority(string $priority): Priority
    {
        $parsed = Priority::tryFrom($priority);

        if ($parsed === null) {
            throw new InvalidArgumentException("Invalid priority: {$priority}");
        }

        return $parsed;
    }

    private function parseStatus(string $status): TaskStatus
    {
        $parsed = TaskStatus::tryFrom($status);

        if ($parsed === null) {
            throw new InvalidArgumentException("Invalid status: {$status}");
        }

        return $parsed;
    }

    /**
     * @return array<string, mixed>
     */
    private function mapToArray(TaskItem $task): array
    {
        return [
            'id' => $task->id,
            'title' => $task->title,
            'description' => $task->description,
            'priority' => $task->priority->value,
            'status' => $task->status->value,
            'created_at' => $task->createdAt->toIso8601String(),
            'completed_at' => $task->completedAt?->toIso8601String(),
            'owner_id' => $task->ownerId,
            'assignee_id' => $task->assigneeId,
        ];
    }
}
