# Three Ways to Work with AI

**Module 4 — GitHub Copilot for Laravel Developers**

<!-- end_slide -->

## Opening scenario

A developer on your team has been using Copilot for a month. They use it constantly — but always the same way: type something, accept the suggestion, move on.

Their code works. But their prompts are still vague, the output often needs reworking, and they've never used Chat or written a spec.

**Type in chat: what's the one thing you'd tell them to do differently?**

- Pull out repeated/repetitive prompting
- Make a file with constant constraints to adhere to and have it reference that
- Pair programming/apprenticeship learning - watch/work alongside someone who is doing it well
- If they hadn't written a spec - how they know they are understanding the goal?
- Do you understand the requirements?


<!-- end_slide -->

## Three modes, three mental models

| Mode | Where | Mental model |
|---|---|---|
| Inline | Editor, as you type | You're driving. Copilot is suggesting. |
| Chat | Copilot Chat panel | You're asking a colleague who can see your code. |
| PRD-driven | Chat + a structured spec | You're the architect. Copilot is the developer. |

<!-- pause -->

Mixing them up is the most common source of frustration. Each one needs different input to work well.

<!-- end_slide -->

## Mode 1: Inline completion

Copilot watches what you're typing and offers completions — a line, a method body, a block.

<!-- incremental_lists: true -->

**Works well for:**
- Boilerplate you know well — Eloquent models, Form Requests, constructors
- Completing a pattern you've already started
- Quick edits: missing parameter, match case, null guard
- Staying in flow — no context switch

<!-- pause -->

**Breaks down when:**
- You haven't given it enough signal — a blank file or a vague method name
- You want something non-obvious — it guesses conservatively
- You need to reason about a design decision

<!-- end_slide -->

## Getting more from inline: signal

Copilot reads your method name, parameters, nearby code, and comments. The more signal, the better the suggestion.

**Name with intent:**
```php
// vague
public function process(int $id): void { }

// directed
public function validateAndSaveUserProfile(int $userId): ValidationResult { }
```

<!-- pause -->

**Comment first, then signature:**
```php
// Validate email uniqueness before saving. Return ValidationResult with field errors.
public function saveUser(UserDto $dto): ValidationResult
```

<!-- pause -->

**Start the pattern:** write the first property — Copilot completes the rest.

<!-- end_slide -->

## Accepting suggestions: the habit

`Tab` accepts everything. `Ctrl+→` accepts word by word. `Esc` rejects.

**Use `Ctrl+→` more than `Tab`.** Reading word by word before accepting is the habit that stops subtle bugs getting in.

<!-- pause -->
<!-- incremental_lists: true -->
**What to watch for:**
- Wrong null handling assumptions
- Validation logic that was elsewhere in the file, silently omitted
- Method names or types that are subtly off from your conventions


**The rule:** if you wouldn't have written it that way, question it before accepting.

<!-- end_slide -->

## Mode 2: Copilot Chat

A conversation with Copilot that has context about your workspace — open files, selected code, project structure.

<!-- incremental_lists: true -->
**Use Chat when you're thinking, not just writing:**
- You need to understand something — `what does this method actually do?`
- You're making a design decision — `should this be a service or a middleware?`
- You're generating something complex — a full controller, a Pest test suite
- You're stuck and want to think through options before committing


**A practical pattern:**
1. Chat to explore the approach
2. Chat to generate the first draft
3. Inline to fill in details as you refine

Chat is not a better search engine. It's where you do the thinking.

<!-- end_slide -->

## Slash commands

| Command | Use it for |
|---|---|
| `/explain` | Understand what selected code does |
| `/fix` | Diagnose and fix a problem in selected code |
| `/tests` | Generate tests for selected code |
| `/doc` | Generate PHPDoc comments |
| `/new` | Scaffold a new file or class |

<!-- pause -->

**Select the relevant code first, then run the command.** The selection is the context. Running `/fix` on the whole file when only one method is broken gives Copilot too much noise.

<!-- end_slide -->

## Referencing files in Chat

Pull specific files into the conversation with `#`:

```
#file:TaskRepositoryInterface.php — generate an Eloquent implementation of this interface.
Use constructor injection. Follow the naming conventions in the file.
```

<!-- pause -->

```
#file:UserService.php — this method throws a null pointer on line 47.
What's the likely cause, and how do I fix it?
```

<!-- pause -->

**Discussion — type in chat:** you're using `/fix` on a `delete` method that has three problems — a missing null check, `Carbon::now()` instead of `Carbon::now('UTC')`, and a missing ownership check. Does Copilot catch all three, or does it prioritise? Which would you most want it to catch?


<!-- end_slide -->

## Mode 3: PRD-driven development

Writing a structured specification and using it as the prompt for a complete, consistent feature.
<!-- incremental_lists: true -->
**Why the first two modes aren't enough for a full feature:**
- Inline produces one line at a time
- Chat produces one layer at a time
- Without a shared spec, you get inconsistent naming, missing validation, fragmented error patterns


With a spec, every layer — Form Request, service, controller, tests — has the same source of truth.

<!-- pause -->

**The spec is also useful after the AI is done.** Use it in code review. Use it to onboard someone to the feature. It's your requirements document.

<!-- end_slide -->

## What a good PRD contains

A PRD for Copilot needs four things:
<!-- pause -->

- **1. Stack and conventions** — version, injection style, patterns to follow
- **2. Shape of the data** — request fields, types, constraints, response shape
- **3. Behaviour as a list** — what it does step by step, including error cases
- **4. Acceptance criteria** — specific, testable statements Copilot can generate tests against


The acceptance criteria are the most important part. They're what the tests verify. If they're vague, the tests will be vague.

<!-- end_slide -->

## PRD format: plain markdown spec

```markdown
## Feature: Update task priority

**Stack:** Laravel 11+, PHP 8.3. Constructor injection throughout.

**Endpoint:** PATCH /api/tasks/{id}/priority

**Request:** priority (string — Low, Medium, High)

**Behaviour:**
- Validate priority is one of the allowed values (Form Request)
- Check the task belongs to the requesting user (owner_id)
- Update and save
- Return 200 with updated TaskResource on success
- Return 404 if task not found
- Return 403 if task belongs to a different user
- Return 422 if priority value is invalid

**Acceptance criteria:**
- [ ] Invalid priority returns 422 with a descriptive error
- [ ] Task not found returns 404
- [ ] Task owned by another user returns 403, not 404
- [ ] Successful update returns 200 with the updated TaskResource
```

<!-- end_slide -->

## PRD format: user story

```markdown
## User Story: Update task priority

**As a** project member
**I want to** change the priority of a task I own
**So that** I can reflect changing urgency without reassigning the task

**Acceptance criteria:**
- [ ] PATCH /api/tasks/{id}/priority accepts Low, Medium, or High
- [ ] Returns 403 if the task belongs to another user — not 404
- [ ] Returns 422 with field-level error if priority value is invalid
- [ ] Returns 200 with updated TaskResource on success

**Technical notes:**
- Stack: Laravel 11+, Eloquent, Form Requests
- Follow existing JSON error response shape
- See TaskRepositoryInterface.php for the repository interface
```

<!-- pause -->

Both formats work. The user story format is easier to share with non-technical stakeholders. The markdown spec format is easier for Copilot to generate consistent output from.

<!-- end_slide -->

## Generating from a spec: the sequence

Paste the spec once. Then generate each layer in sequence, referencing the previous output.

**Step 1 — Form Request and validation:**
```
Using this spec: [paste]
Generate UpdateTaskPriorityRequest with validation rules.
```

**Step 2 — Service method:**
```
Using the spec and the Form Request we just created, generate the service method.
Include the ownership check and the error cases from the spec.
```

**Step 3 — Controller endpoint:**
```
Generate the controller endpoint. Follow the response shapes and status codes in the spec.
```

**Step 4 — Tests:**
```
Generate Pest tests covering every acceptance criterion in the spec.
```

<!-- end_slide -->

## When output diverges from the spec

It will. The question is how to recover without starting again.

**Naming inconsistency** — the service uses `task_priority` but the Form Request uses `priority`:
> "The spec uses `priority` throughout. Rename `task_priority` in the service to match."

<!-- pause -->

**Missing behaviour** — the 403/404 distinction is collapsed into a single 404:
> "The spec requires 403 when the task exists but belongs to another user. Add that check before the 404."

<!-- pause -->

**Wrong error shape** — validation errors don't match Laravel's JSON format:
> "Error responses should use Laravel's validation JSON shape with field-level errors. Rewrite the error returns to match."

<!-- pause -->

**The principle:** treat divergence as a spec refinement task, not a prompt failure. Add the missing constraint to the spec so the next layer inherits it.

<!-- end_slide -->

## Iterating on the spec itself

If the output keeps diverging in the same way, the spec is missing a constraint.

**Common gaps:**

- Error response shape not specified → add a `**Response format:**` section
- Naming conventions not specified → add `Follow the naming in #file:TaskController.php`
- Which layer owns which responsibility not specified → add to the behaviour list explicitly

<!-- pause -->

A spec that produces consistent output across all four layers on the first attempt is a well-written spec. Most take one or two iterations to get there. That's normal — and the refined spec is worth keeping.

<!-- end_slide -->

## Choosing your mode

| Task | Mode |
|---|---|
| Writing a Form Request or model | Inline |
| Completing a method you've started | Inline |
| Understanding what legacy code does | Chat `/explain` |
| Diagnosing a bug | Chat `/fix` |
| Generating a full service class | Chat |
| Generating tests for a class | Chat `/tests` |
| Building a feature across multiple files | PRD-driven |
| Onboarding someone to a feature | PRD (spec as documentation) |

<!-- pause -->

**The underlying principle:** AI works best when it has constraints. Inline needs signal. Chat needs a well-framed question with the right files in scope. PRD-driven needs a spec that defines the shape before you ask for it.

<!-- end_slide -->

## Summary

1. **Inline** — use when you're writing and want completion; give it signal through names, comments, and patterns
2. **Chat** — use when you're thinking; explore, explain, design, generate larger pieces with slash commands and `#file`
3. **PRD-driven** — use when you're building a feature; write the spec first, generate in layers, treat divergence as a spec gap

The goal is not to use AI more. It's to use the right mode for the right task — and stay in control of the output.

<!-- end_slide -->

# Questions?

*Module 4 — Three Ways to Work with AI*
