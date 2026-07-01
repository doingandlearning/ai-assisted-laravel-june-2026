<?php

use App\Enums\Priority;
use App\Enums\TaskStatus;
use App\Models\TaskItem;
use App\Repositories\TaskRepositoryInterface;
use App\Services\TaskService;
use Illuminate\Support\Carbon;

beforeEach(function () {
    $this->repository = Mockery::mock(TaskRepositoryInterface::class);
    $this->service = new TaskService($this->repository);
});

afterEach(function () {
    Mockery::close();
});

describe('create', function () {
    it('returns mapped response for valid request', function () {
        $this->repository
            ->shouldReceive('save')
            ->once()
            ->with(Mockery::type(TaskItem::class))
            ->andReturnUsing(function (TaskItem $task) {
                $task->id = 1;

                return $task;
            });

        $result = $this->service->create([
            'title' => 'Fix login bug',
            'description' => "Users can't log in",
            'priority' => 'High',
            'owner_id' => 42,
        ]);

        expect($result['id'])->toBe(1)
            ->and($result['title'])->toBe('Fix login bug')
            ->and($result['priority'])->toBe('High')
            ->and($result['owner_id'])->toBe(42);
    });

    it('throws for empty title', function () {
        $this->service->create([
            'title' => '',
            'priority' => 'Medium',
            'owner_id' => 1,
        ]);
    })->throws(InvalidArgumentException::class);

    it('throws when title exceeds 100 characters', function () {
        $this->service->create([
            'title' => str_repeat('x', 101),
            'priority' => 'Medium',
            'owner_id' => 1,
        ]);
    })->throws(InvalidArgumentException::class);

    it('throws for invalid priority', function () {
        $this->service->create([
            'title' => 'Valid title',
            'priority' => 'Urgent',
            'owner_id' => 1,
        ]);
    })->throws(InvalidArgumentException::class);

    it('calls repository save once', function () {
        $this->repository
            ->shouldReceive('save')
            ->once()
            ->with(Mockery::type(TaskItem::class))
            ->andReturnUsing(function (TaskItem $task) {
                $task->id = 1;

                return $task;
            });

        $this->service->create([
            'title' => 'A task',
            'priority' => 'Low',
            'owner_id' => 1,
        ]);
    });
});

describe('update', function () {
    it('returns null for non-existent id', function () {
        $this->repository
            ->shouldReceive('getById')
            ->with(99)
            ->andReturn(null);

        $result = $this->service->update(99, []);

        expect($result)->toBeNull();
    });

    it('sets completed_at when status set to done', function () {
        $existing = new TaskItem;
        $existing->id = 1;
        $existing->title = 'A task';
        $existing->ownerId = 1;

        $this->repository->shouldReceive('getById')->with(1)->andReturn($existing);
        $this->repository
            ->shouldReceive('update')
            ->once()
            ->with(Mockery::type(TaskItem::class))
            ->andReturnUsing(fn (TaskItem $task) => $task);

        $result = $this->service->update(1, ['status' => 'Done']);

        // NOTE FOR DEMO: This test currently FAILS — there's a bug in update().
        // Use /fix to find and correct it.
        expect($result['completed_at'])->not->toBeNull();
    });

    it('updates title and persists', function () {
        $existing = new TaskItem;
        $existing->id = 1;
        $existing->title = 'Before';
        $existing->ownerId = 1;
        $saved = null;

        $this->repository->shouldReceive('getById')->with(1)->andReturn($existing);
        $this->repository
            ->shouldReceive('update')
            ->once()
            ->with(Mockery::type(TaskItem::class))
            ->andReturnUsing(function (TaskItem $task) use (&$saved) {
                $saved = $task;

                return $task;
            });

        $result = $this->service->update(1, ['title' => 'After']);

        expect($saved?->title)->toBe('After')
            ->and($result['title'])->toBe('After');
    });

    it('throws for whitespace title', function (string $badTitle) {
        $existing = new TaskItem;
        $existing->id = 1;
        $existing->title = 'Original';
        $existing->ownerId = 1;

        $this->repository->shouldReceive('getById')->with(1)->andReturn($existing);
        $this->repository->shouldNotReceive('update');

        $this->service->update(1, ['title' => $badTitle]);
    })->throws(InvalidArgumentException::class)->with(['', '   ']);

    it('updates priority and persists', function () {
        $existing = new TaskItem;
        $existing->id = 1;
        $existing->title = 'Task';
        $existing->priority = Priority::Low;
        $existing->ownerId = 1;
        $saved = null;

        $this->repository->shouldReceive('getById')->with(1)->andReturn($existing);
        $this->repository
            ->shouldReceive('update')
            ->once()
            ->andReturnUsing(function (TaskItem $task) use (&$saved) {
                $saved = $task;

                return $task;
            });

        $result = $this->service->update(1, ['priority' => 'High']);

        expect($saved?->priority)->toBe(Priority::High)
            ->and($result['priority'])->toBe('High');
    });

    it('throws for invalid priority', function () {
        $existing = new TaskItem;
        $existing->id = 1;
        $existing->title = 'Task';
        $existing->ownerId = 1;

        $this->repository->shouldReceive('getById')->with(1)->andReturn($existing);
        $this->repository->shouldNotReceive('update');

        $this->service->update(1, ['priority' => 'NotARealPriority']);
    })->throws(InvalidArgumentException::class);

    it('throws for invalid status', function () {
        $existing = new TaskItem;
        $existing->id = 1;
        $existing->title = 'Task';
        $existing->ownerId = 1;

        $this->repository->shouldReceive('getById')->with(1)->andReturn($existing);
        $this->repository->shouldNotReceive('update');

        $this->service->update(1, ['status' => 'NotARealStatus']);
    })->throws(InvalidArgumentException::class);

    it('sets completed_at when transitioning to done from todo', function () {
        $existing = new TaskItem;
        $existing->id = 1;
        $existing->title = 'Task';
        $existing->status = TaskStatus::Todo;
        $existing->completedAt = null;
        $existing->ownerId = 1;
        $saved = null;

        $this->repository->shouldReceive('getById')->with(1)->andReturn($existing);
        $this->repository
            ->shouldReceive('update')
            ->once()
            ->andReturnUsing(function (TaskItem $task) use (&$saved) {
                $saved = $task;

                return $task;
            });

        $before = Carbon::now('UTC');
        $result = $this->service->update(1, ['status' => 'Done']);
        $after = Carbon::now('UTC');

        expect($saved?->completedAt)->not->toBeNull()
            ->and($saved?->completedAt?->between($before, $after))->toBeTrue()
            ->and($result['completed_at'])->not->toBeNull();
    });

    it('preserves completed_at when already set and transitioning to done', function () {
        $fixedCompletedAt = Carbon::parse('2024-02-03 04:05:06', 'UTC');
        $existing = new TaskItem;
        $existing->id = 1;
        $existing->title = 'Task';
        $existing->status = TaskStatus::InProgress;
        $existing->completedAt = $fixedCompletedAt;
        $existing->ownerId = 1;
        $saved = null;

        $this->repository->shouldReceive('getById')->with(1)->andReturn($existing);
        $this->repository
            ->shouldReceive('update')
            ->once()
            ->andReturnUsing(function (TaskItem $task) use (&$saved) {
                $saved = $task;

                return $task;
            });

        $result = $this->service->update(1, ['status' => 'Done']);

        expect($saved?->completedAt?->equalTo($fixedCompletedAt))->toBeTrue()
            ->and($result['completed_at'])->toBe($fixedCompletedAt->toIso8601String());
    });

    it('clears completed_at when transitioning from done to non-done', function () {
        $existing = new TaskItem;
        $existing->id = 1;
        $existing->title = 'Task';
        $existing->status = TaskStatus::Done;
        $existing->completedAt = Carbon::parse('2024-03-04 05:06:07', 'UTC');
        $existing->ownerId = 1;
        $saved = null;

        $this->repository->shouldReceive('getById')->with(1)->andReturn($existing);
        $this->repository
            ->shouldReceive('update')
            ->once()
            ->andReturnUsing(function (TaskItem $task) use (&$saved) {
                $saved = $task;

                return $task;
            });

        $result = $this->service->update(1, ['status' => 'InProgress']);

        expect($saved?->completedAt)->toBeNull()
            ->and($result['completed_at'])->toBeNull();
    });
});

describe('getByOwner', function () {
    it('returns only matching priority tasks', function () {
        $task = new TaskItem;
        $task->id = 1;
        $task->title = 'Urgent fix';
        $task->priority = Priority::High;
        $task->ownerId = 1;

        $this->repository
            ->shouldReceive('getByOwner')
            ->with(1, Priority::High)
            ->andReturn([$task]);

        $results = $this->service->getByOwner(1, 'High');

        expect($results)->toHaveCount(1)
            ->and($results[0]['priority'])->toBe('High');
    });
});

// -------------------------------------------------------------------------
// DEMO GAPS — good for TDD exercise
// -------------------------------------------------------------------------

// TODO: Add tests for:
// - create with whitespace-only title (should fail)
// - getByOwner with invalid priority string
// - delete delegates to repository
