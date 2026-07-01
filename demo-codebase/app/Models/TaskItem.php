<?php

namespace App\Models;

use App\Enums\Priority;
use App\Enums\TaskStatus;
use Illuminate\Support\Carbon;

class TaskItem
{
    public int $id = 0;

    public string $title;

    public ?string $description = null;

    public Priority $priority = Priority::Medium;

    public TaskStatus $status = TaskStatus::Todo;

    public Carbon $createdAt;

    public ?Carbon $completedAt = null;

    public int $ownerId;

    public function __construct()
    {
        $this->createdAt = Carbon::now('UTC');
    }
}
