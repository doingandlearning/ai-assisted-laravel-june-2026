# Task Management API — Demo Codebase

A Laravel 13 Task Management API used as the teaching vehicle for the *AI-Assisted Development for Laravel Teams* course.

---

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan serve
```

API runs at `http://127.0.0.1:8000/api`.

Run the test suite:

```bash
./vendor/bin/pest tests/Unit/TaskServiceTest.php
```

Expect **two failing tests** on first run. This is intentional — see demo notes below.

---

## Architecture

```
routes/api.php
    └─ TaskController          (thin — Form Requests, TaskResource, TaskService)
           └─ TaskService      (business logic — has one intentional bug)
                  └─ TaskRepositoryInterface
                         └─ InMemoryTaskRepository  (JSON-backed — no database)
                                └─ TaskItem         (plain PHP model, not Eloquent)

Supporting:
    Enums:         Priority, TaskStatus
    Form Requests: StoreTaskRequest, UpdateTaskRequest
    Resource:      TaskResource
```

Tasks are stored in `storage/app/demo-tasks.json`. No database table. The standard Laravel `users` table exists for migrations practice, but the API has no authentication.

---

## API Endpoints

| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/tasks?owner_id=1` | List tasks for an owner (optional priority filter) |
| GET | `/api/tasks/{id}` | Get a single task |
| POST | `/api/tasks` | Create a task |
| PATCH | `/api/tasks/{id}` | Update a task |
| PATCH | `/api/tasks/{id}/archive` | Archive a task — **stub only, not implemented** |
| DELETE | `/api/tasks/{id}` | Delete a task — **endpoint missing, used in PRD demo** |

---

## Intentional demo targets

### Bug in `TaskService::update()` — Module 02 `/fix` demo

`update()` never sets `completedAt` when a task transitions to `Done`. The condition only handles the reverse (Done → non-Done).

```php
// The bug: only clears, never sets
if ($previousStatus === TaskStatus::Done && $parsedStatus !== TaskStatus::Done) {
    $existing->completedAt = null;
}
```

The test `it('sets completed_at when status set to done')` fails and is the target for the Copilot Chat `/fix` demo.

### Incomplete `delete()` in `InMemoryTaskRepository` — Module 02 inline demo

```php
public function delete(int $id): bool
{
    // TODO: implement delete
    // Good inline demo: let Copilot complete this from the method signature + context
    throw new \BadMethodCallException('Delete is not implemented yet.');
}
```

### Missing `archive()` in `TaskService` — Module 04 TDD harness demo

`TaskService::archive()` is a stub that throws `BadMethodCallException`. Three tests in `describe('archive')` are failing. This is the agent TDD demo: hand the failing tests to an agent, observe it implement the method.

### Missing DELETE endpoint — Module 02 PRD demo

No `delete()` method on `TaskController` and no DELETE route. Used for the PRD-driven development exercise: delegates write a user story spec and generate the endpoint in layers.

### `ReviewDemoController` — Module 03 code review demo

`app/Http/Controllers/Api/ReviewDemoController.php` contains a controller with five deliberate problems for the code review demo. See inline comments.

### `LegacyTaskManager` — Module 03 explanation demo

`app/Legacy/LegacyTaskManager.php` is a pre-framework PHP class written in an older style. Used for the layered explanation demo (what does it do / why was it written this way / what's the modern equivalent / what breaks if I change it).

---

## Test suite

```
tests/Unit/TaskServiceTest.php   — Pest + Mockery unit tests for TaskService
tests/Feature/ExampleTest.php    — Stock Laravel feature test (GET / returns 200)
```

On first run, expect:
- `it('sets completed_at when status set to done')` — **FAILS** (planted bug in update)
- `it('sets completed_at when transitioning to done from todo')` — **FAILS** (same bug)
- All `describe('archive', ...)` tests — **FAIL** (method not implemented)

All other tests pass.
