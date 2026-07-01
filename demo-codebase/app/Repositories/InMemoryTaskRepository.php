<?php

namespace App\Repositories;

use App\Enums\Priority;
use App\Enums\TaskStatus;
use App\Models\TaskItem;
use Illuminate\Support\Carbon;

// NOTE FOR DEMO: This is an in-memory implementation so the project runs
// without a database. Tasks are persisted to a JSON file so they survive
// HTTP requests when using `php artisan serve`. In a real project this would use Eloquent.
// Good candidate for: /explain, inline completion of missing methods
class InMemoryTaskRepository implements TaskRepositoryInterface
{
    /** @var TaskItem[] */
    private array $tasks = [];

    private int $nextId = 1;

    public function __construct()
    {
        $this->load();
    }

    public function getById(int $id): ?TaskItem
    {
        foreach ($this->tasks as $task) {
            if ($task->id === $id) {
                return $task;
            }
        }

        return null;
    }

    public function getByOwner(int $ownerId, ?Priority $priority = null): array
    {
        $results = array_values(array_filter(
            $this->tasks,
            fn (TaskItem $task) => $task->ownerId === $ownerId
                && ($priority === null || $task->priority === $priority),
        ));

        usort($results, fn (TaskItem $a, TaskItem $b) => $b->createdAt <=> $a->createdAt);

        return $results;
    }

    public function save(TaskItem $task): TaskItem
    {
        $task->id = $this->nextId++;
        $this->tasks[] = $task;
        $this->persist();

        return $task;
    }

    public function update(TaskItem $task): ?TaskItem
    {
        foreach ($this->tasks as $index => $existing) {
            if ($existing->id === $task->id) {
                $this->tasks[$index] = $task;
                $this->persist();

                return $task;
            }
        }

        return null;
    }

    // TODO: implement delete
    // Good demo: ask Copilot inline to complete this
    public function delete(int $id): bool
    {
        throw new \BadMethodCallException('Delete is not implemented yet.');
    }

    private function storagePath(): string
    {
        return storage_path('app/demo-tasks.json');
    }

    private function load(): void
    {
        $path = $this->storagePath();

        if (! is_file($path)) {
            return;
        }

        $contents = file_get_contents($path);

        if ($contents === false) {
            return;
        }

        $data = json_decode($contents, true);

        if (! is_array($data)) {
            return;
        }

        $this->nextId = (int) ($data['next_id'] ?? 1);
        $this->tasks = array_map(
            fn (array $row) => $this->taskFromArray($row),
            $data['tasks'] ?? [],
        );
    }

    private function persist(): void
    {
        $payload = [
            'next_id' => $this->nextId,
            'tasks' => array_map(
                fn (TaskItem $task) => $this->taskToArray($task),
                $this->tasks,
            ),
        ];

        file_put_contents(
            $this->storagePath(),
            json_encode($payload, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR),
            LOCK_EX,
        );
    }

    /**
     * @return array<string, mixed>
     */
    private function taskToArray(TaskItem $task): array
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

    /**
     * @param  array<string, mixed>  $row
     */
    private function taskFromArray(array $row): TaskItem
    {
        $task = new TaskItem;
        $task->id = (int) $row['id'];
        $task->title = (string) $row['title'];
        $task->description = $row['description'] ?? null;
        $task->priority = Priority::from((string) $row['priority']);
        $task->status = TaskStatus::from((string) $row['status']);
        $task->createdAt = Carbon::parse((string) $row['created_at']);
        $task->completedAt = isset($row['completed_at']) && $row['completed_at'] !== null
            ? Carbon::parse((string) $row['completed_at'])
            : null;
        $task->ownerId = (int) $row['owner_id'];
        $task->assigneeId = isset($row['assignee_id']) && $row['assignee_id'] !== null
            ? (int) $row['assignee_id']
            : null;

        return $task;
    }
}
