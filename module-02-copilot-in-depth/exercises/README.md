# Module 4 — Exercises

**For delegates.** These exercises run during the Module 4 session. Your facilitator will manage timing and breakout rooms. Exercises are designed to be done in VS Code with GitHub Copilot for Business active.

---

## Objective

By the end of these exercises you will be able to:

- Read inline suggestions critically before accepting them
- Use `/explain`, `/fix`, and `/tests` and notice what each one misses
- Generate a multi-layer feature from a spec and identify where the output diverges from your intent
- Write a spec that someone else could generate from — and that you could use in a real code review

---

## Exercise 1: Inline — signal and what it changes

**Individual (10 minutes)**

Open a new PHP file. You're going to generate a simple model class three times, with increasing signal each time.

**Round 1 — minimal signal:**

Type only this and trigger inline completion:

```php
class Task
{
```

Don't accept anything yet. Note what's suggested.

**Round 2 — named intent:**

Replace the class with this and trigger again:

```php
// Represents a task in a project management system.
// Properties: id, title (required, max 100 chars), description (optional),
// priority (enum: Low, Medium, High), created_at (UTC), owner_id (int).
class TaskItem
{
```

**Round 3 — pattern started:**

```php
class TaskItem
{
    public int $id;
    public string $title;
```

Stop there and let Copilot continue.

**The decision:** Based on what you observed, in which of these situations would you reach for inline rather than Chat?

- Writing a `StoreTaskRequest` Form Request with eight validation rules you already know
- Writing a service method with a non-obvious null-handling requirement
- Completing a `match` expression over a known enum you've already started
- Writing a repository interface for an entity you haven't defined yet

**Type your answers in chat (use inline / use Chat for each).** Be prepared to defend one you're unsure about.

---

## Exercise 2: Chat — what the slash commands catch and miss

**Individual (15 minutes), then breakout (5 minutes)**

Use the following service class. Paste it into a new file in your project.

```php
<?php

namespace App\Services;

use App\Models\TaskItem;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Support\Carbon;
use InvalidArgumentException;

class TaskService
{
    public function __construct(
        private readonly TaskRepositoryInterface $repository,
    ) {}

    public function create(array $data): TaskItem
    {
        if (trim($data['title'] ?? '') === '') {
            throw new InvalidArgumentException('Title is required');
        }

        if (strlen($data['title']) > 100) {
            throw new InvalidArgumentException('Title cannot exceed 100 characters');
        }

        $task = new TaskItem;
        $task->title = $data['title'];
        $task->description = $data['description'] ?? null;
        $task->priority = $data['priority'];
        $task->ownerId = (int) $data['owner_id'];
        $task->createdAt = Carbon::now('UTC');

        return $this->repository->save($task);
    }

    public function getByOwner(int $ownerId, ?string $priority = null): array
    {
        $tasks = $this->repository->getByOwner($ownerId);

        if ($priority !== null) {
            $tasks = array_filter($tasks, fn ($t) => $t->priority->value === $priority);
        }

        usort($tasks, fn ($a, $b) => $b->createdAt <=> $a->createdAt);

        return $tasks;
    }
}
```

**Part A — `/explain`:**

Select `getByOwner`. Run `/explain`. Read it.

Is there anything in the explanation that's subtly wrong, or that you'd want to verify? The method filters and sorts — does the explanation correctly describe *when* filtering happens relative to the database call?

**Part B — `/fix`:**

Add this method to the class:

```php
public function delete(int $taskId, int $requestingUserId): void
{
    $task = $this->repository->getById($taskId);
    $task->deletedAt = Carbon::now();
    $this->repository->save($task);
}
```

Select it and run `/fix`. This method has three problems:
- No null check on `$task`
- `Carbon::now()` instead of `Carbon::now('UTC')`
- No ownership check — any user can delete any task

**Does `/fix` catch all three?** Note which ones it flags and which it misses. If it misses one, follow up in Chat with a prompt that surfaces the missing issue.

**Part C — `/tests`:**

Select the entire `TaskService` class and run `/tests`. Then check:

- Does it cover the empty-title validation path?
- Does it cover the title-too-long path?
- Does it cover filtering by each priority value in `getByOwner`?

Follow up: `"Add a Pest test for when getByOwner is called with a null priority filter — what should it return?"`

**In your breakout room:** Compare what `/fix` caught and missed across your pair. **Agree on this: of the three problems in `delete`, which is the most dangerous to miss — and why does it matter whether Copilot catches it or you have to?**

---

## Exercise 3: PRD-driven — generate and find the divergence

**Individual (20 minutes), then whole group**

Use the following spec. Your task is to generate the feature in layers — and find at least one place where the output diverges from the spec.

```markdown
## Feature: Update task priority

**Stack:** Laravel 11+, PHP 8.3. Constructor injection throughout.
Follow the existing JSON error response shape (422 validation errors as a field map,
API Resource for success responses).

**Endpoint:** PATCH /api/tasks/{id}/priority

**Request:** priority (string — must be one of: Low, Medium, High)

**Behaviour:**
- Validate that priority is one of the allowed values (Form Request)
- Check the task belongs to the requesting user via owner_id
- Update the priority and save
- Return 200 with the updated TaskResource on success
- Return 404 if the task is not found
- Return 403 if the task exists but belongs to a different user
- Return 422 with a field-level error if the priority value is invalid

**Acceptance criteria:**
- [ ] Invalid priority value returns 422 with a descriptive field error
- [ ] Task not found returns 404
- [ ] Task owned by another user returns 403 — not 404
- [ ] Successful update returns 200 with updated TaskResource
```

**Step 1:** Paste the spec and ask for the Form Request with validation rules.

**Step 2:** Using the Form Request as context, ask for the service method.

**Step 3:** Ask for the controller endpoint.

**Step 4:** Ask for Pest tests covering the acceptance criteria.

**The question to answer:** Where did the output diverge from the spec? Look specifically for:
- The 403 vs. 404 distinction — did the service implement it, or collapse it to a single case?
- The error response shape — does it use Laravel's validation JSON format, or a custom shape?
- Naming — is `priority` spelled and cased consistently across all four layers?

**Type in chat:** the single most important divergence you found, and the one-line spec addition that would have prevented it.

---

## Exercise 4: Write a spec that could go into production

**Breakout — 15 minutes**

This is the exercise that produces something you can use next week.

Think of a feature from your current or recent work that spans at least two layers — a controller calling a service, or a service calling a repository. It doesn't have to be complex. A single endpoint that does one thing well is enough.

Write the spec using either format:

**Option A — markdown spec:**

```markdown
## Feature: [name]

**Stack:** Laravel 11+, PHP 8.3 — [your conventions: Form Requests, API Resources, service layer, etc.]

**Endpoint / entry point:** [route and controller method]

**Request / input:** [fields, types, validation rules]

**Behaviour:** [step by step, including error cases — 404, 403, 422]

**Acceptance criteria:**
- [ ] ...
```

**Option B — user story:**

```markdown
## User Story: [name]

**As a** [user type]
**I want to** [goal]
**So that** [reason]

**Acceptance criteria:**
- [ ] ...

**Technical notes:**
- Stack: Laravel 11+, Pest for tests
- Patterns to follow: Form Request → service → controller → API Resource
- See #file:TaskController.php for existing conventions
```

**In your breakout room:** Swap specs. Read your partner's spec and answer three questions:

1. Could you implement this from the spec alone, without asking a clarifying question?
2. Is there any acceptance criterion that isn't testable as written?
3. Is the 403/404 distinction (or equivalent ownership/authorisation edge case) covered?

Give them one specific rewrite of the weakest acceptance criterion — not general feedback, a rewrite.

**Feed back to the room:** Did your partner find a gap you didn't notice when writing? What kind of gap was it — missing behaviour, untestable criterion, or ambiguous ownership rule?

---

## Extensions

If you finish early or want to go deeper:

1. **Generate your own spec:** Take the spec you wrote in Exercise 4 and generate the feature. Compare the output to what you'd have written manually. Note what you had to refine — and add those refinements back to the spec.

2. **`#file` in practice:** Add a `**Patterns to follow:**` section to your spec that references a real file — `#file:TaskController.php`. Does the output more closely match your existing codebase conventions?

3. **Format comparison:** Take any spec from today and rewrite it in the format you didn't use. Which format makes acceptance criteria easier to express? Which makes the technical constraints clearer?

4. **Spec as documentation:** Take your finished spec and paste it into a Confluence page or README alongside the code it generated. Is it a useful description of the feature for someone who didn't write it?

---

## Before you finish

Make sure you have:

- [ ] Observed how signal quality affects inline suggestions — and know when to use Chat instead (Exercise 1)
- [ ] Used `/explain`, `/fix`, and `/tests` and noted what each one missed, not just what it found (Exercise 2)
- [ ] Generated a feature from a spec and identified at least one divergence — and the spec addition that would have prevented it (Exercise 3)
- [ ] Written a spec that someone else reviewed — and received one specific rewrite of a weak criterion (Exercise 4)

The spec you wrote in Exercise 4 is the most reusable thing you're leaving with. Keep it. Refine it against the first time you generate from it.
