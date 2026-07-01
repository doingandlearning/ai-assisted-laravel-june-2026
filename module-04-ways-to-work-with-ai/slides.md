# Three Ways to Work with AI

**Module 4 — GitHub Copilot for Laravel Developers**

---

## Learning objectives

By the end of this module you will be able to:

- Use **inline completion** effectively: when to accept, reject, and steer suggestions
- Use **Copilot Chat** effectively: when to use chat over inline, and how to get useful responses
- Write a **PRD-style spec** that lets AI generate consistent, production-quality code across multiple files
- Choose the right mode for the task in front of you

---

## Bridge from Module 3

**What we covered:**

- How to write prompts that produce useful Laravel/PHP code
- Controlling output quality: generation, explanation, refactoring, testing

**The gap:**

You know how to write a good prompt. But you're probably switching between modes without a strategy — sometimes inline, sometimes chat, sometimes neither.

---

**Today:** Three distinct workflows. Understand what each one is for, and when to reach for it.

---

## The three modes

| Mode           | Where it lives                    | Best for                                   |
| -------------- | --------------------------------- | ------------------------------------------ |
| **Inline**     | Inside the editor, as you type    | Boilerplate, completions, quick edits      |
| **Chat**       | Copilot Chat panel or inline chat | Exploration, explanation, design decisions |
| **PRD-driven** | Chat + a structured spec          | Multi-file features, consistent output     |

---

Each one has a different mental model. Mixing them up is the most common source of frustration.

---

## Mode 1: Inline completion

**What it is:**

Copilot watches what you're typing and offers completions — a line, a method body, a block.

**The mental model:** You're driving. Copilot is suggesting.

---

**When it works well:**

- ✅ Writing boilerplate you know well (Eloquent models, Form Requests, constructors)
- ✅ Completing a pattern you've started (Copilot continues the shape)
- ✅ Quick fixes: adding a missing parameter, filling in a `match` case
- ✅ Staying in flow — no context switching

---

**When it breaks down:**

- ❌ You haven't given it enough signal (a blank file or vague method name)
- ❌ You want something non-obvious — it will guess conservatively
- ❌ You need to reason about a design decision

---

## Getting more from inline

**Signal matters.** Copilot reads your method name, parameters, nearby code, and comments. The more signal you provide, the better the suggestion.

**Technique 1: Name with intent**

```php
// vague — Copilot guesses
public function process(int $id): void { }

// clear — Copilot has direction
public function validateAndSaveUserProfile(int $userId): ValidationResult { }
```

---

**Technique 2: Write the comment first**

```php
// Validate that the email is unique before saving. Return a ValidationResult.
public function saveUser(UserDto $dto): ValidationResult
```

---

**Technique 3: Start the pattern**

Begin the first property or line — Copilot will complete the rest of the pattern.

---

## Accepting and rejecting suggestions

**Don't accept everything.** That's the fastest way to ship subtle bugs.

- `Tab` — accept the full suggestion
- `Ctrl+→` — accept word by word (use this more often)
- `Esc` — reject and write it yourself

---

**The habit:** Read the suggestion before you accept. If you wouldn't have written it that way, question it.

---

**Watch for:**

- Wrong null handling assumptions
- Missing validation that was elsewhere in the file
- Method names or types that are subtly off

---

## Mode 2: Copilot Chat

**What it is:**

A conversation with Copilot that has context about your workspace — open files, selected code, project structure.

**The mental model:** You're asking a senior developer who can see your code.

---

**When to use chat instead of inline:**

- ✅ You need to explain or understand something ("what does this method actually do?")
- ✅ You're making a design decision ("should this be a service or a repository?")
- ✅ You want to refactor across a file or multiple files
- ✅ You're generating something complex — a full controller, a Pest test suite
- ✅ You're stuck and want to think through options

---

## Copilot slash commands

Built-in shortcuts that tell Copilot what you want:

| Command    | Use it for                                  |
| ---------- | ------------------------------------------- |
| `/explain` | Understand what selected code does          |
| `/fix`     | Diagnose and fix a problem in selected code |
| `/tests`   | Generate tests for selected code            |
| `/doc`     | Generate PHPDoc comments                    |
| `/new`     | Scaffold a new file or class                |

---

**Tip:** Select the relevant code first, then run the command. The selection is the context.

---

## Copilot Chat: referencing files

You can pull specific files into the conversation using `#`:

```
#file:UserService.php — this method is throwing a null pointer on line 47.
What's the likely cause?
```

```
#file:TaskRepositoryInterface.php — generate an Eloquent implementation of this interface.
Use constructor injection.
```

**Use this when:** The code you're asking about isn't the currently selected file.

---

## Chat vs. inline: the decision

**Use inline when** you know what you want and you're writing it — you just want help completing it faster.

---

**Use chat when** you're figuring out what you want, or the task spans more than a few lines.

---

A practical pattern:

1. Use **chat** to explore the approach ("what's the right way to handle this?")
2. Use **chat** to generate the first draft ("generate a service class that does X")
3. Use **inline** to fill in details and make edits as you refine it

Chat is not just a better search engine. It's where you do the thinking.

---

## Mode 3: PRD-driven development

**What it is:**

Writing a structured specification — a mini Product Requirements Document — and using it as the prompt for generating a complete, consistent feature.

---

**The mental model:** You're the architect. You write the spec; Copilot is the developer who implements it.

---

**Why this matters:**

- Inline and chat both produce one thing at a time
- Real features span controllers, services, repositories, Form Requests, API Resources, tests
- Without a spec, you get inconsistent naming, missing validation, fragmented output
- With a spec, you get code that fits together

---

## What a PRD looks like: single feature

**Format: plain markdown spec**

```markdown
## Feature: User registration endpoint

**Stack:** Laravel 11+, PHP 8.3, Eloquent, Form Requests, API Resources

**Endpoint:** POST /api/users/register

**Request body:**

- email (string, required, must be unique)
- password (string, required, min 8 chars)
- display_name (string, required, max 50 chars)

**Behaviour:**

- Validate the request using a Form Request
- Check email uniqueness against the database
- Hash the password before saving
- Return 201 with the created user ID on success
- Return 422 with validation errors on failure
- Return 409 if email already exists

**Acceptance criteria:**

- Validation runs before any database call
- Password is never stored in plain text
- Response body matches the UserResource shape
```

---

## What a PRD looks like: user story format

**Format: GitHub/Azure DevOps-style**

```markdown
## User Story: Register a new account

**As a** new user  
**I want to** create an account with my email and password  
**So that** I can access the application

**Acceptance criteria:**

- [ ] POST /api/users/register accepts email, password, display_name
- [ ] Email must be unique — return 409 if already registered
- [ ] Password must be at least 8 characters
- [ ] Password is hashed before storage (bcrypt)
- [ ] Returns 201 with { userId } on success
- [ ] Returns 422 with field-level validation errors on failure

**Technical notes:**

- Stack: Laravel 11+, Eloquent, Form Requests
- Use constructor injection throughout
- Follow existing repository pattern (see TaskRepositoryInterface.php)
```

---

## Using the spec with Copilot Chat

Once you have a spec, you drive the generation in layers:

**Step 1 — Generate the Form Request:**

```
Using this spec: [paste spec]
Generate the RegisterUserRequest Form Request with validation rules.
```

---

**Step 2 — Generate the service:**

```
Using the same spec and the Form Request we just created, generate the UserRegistrationService.
Inject TaskRepositoryInterface and a password hasher.
```

---

**Step 3 — Generate the controller:**

```
Generate the UsersController with a POST /register endpoint that calls UserRegistrationService.
Follow the response shapes in the spec.
```

---

**Step 4 — Generate the tests:**

```
Generate Pest tests for UserRegistrationService covering the acceptance criteria.
```

---

## PRD-driven: full feature across layers

For a larger feature, the spec grows to describe the full vertical slice:

```markdown
## Feature: Task management — create and list tasks

**Stack:** Laravel 11+, PHP 8.3, Eloquent, Pest

**Endpoints:**

- POST /api/tasks — create a task
- GET /api/tasks — list tasks for the authenticated user

**Data model:**

- TaskItem: id, title (required, max 100), description (optional),
  priority (Low/Medium/High), created_at, owner_id

**Behaviour:**

- Tasks are scoped to the authenticated user
- List endpoint supports filtering by priority
- List returns tasks ordered by created_at descending
- Both endpoints return consistent TaskResource shape

**Layers to generate:**

1. StoreTaskRequest (with validation)
2. TaskRepositoryInterface + Eloquent implementation
3. TaskService
4. TaskController
5. Pest tests for TaskService
```

You generate each layer in sequence, referencing the previous output.

---

## Why specs produce better code

Without a spec, each prompt is isolated:

- The Form Request has different field names than the controller expects
- Validation logic appears in the controller instead of a Form Request
- The service uses a different error pattern than the rest of the codebase
- Tests don't cover the edge cases you actually care about

---

With a spec, Copilot has:

- Consistent naming to follow
- Explicit acceptance criteria to test against
- A clear picture of the layers and their responsibilities

**The spec is also useful after the AI is done.** It's your requirements document. Use it in code review.

---

## Choosing your mode

| Task                                     | Mode                        |
| ---------------------------------------- | --------------------------- |
| Writing a Form Request or model class    | Inline                      |
| Completing a method you've started       | Inline                      |
| Understanding what legacy code does      | Chat `/explain`             |
| Fixing a specific bug                    | Chat `/fix`                 |
| Generating a full service class          | Chat                        |
| Generating tests for a class             | Chat `/tests`               |
| Building a feature across multiple files | PRD-driven                  |
| Onboarding a new developer to a feature  | PRD (spec as documentation) |

---

## The underlying principle

**AI works best when it has constraints.**

Inline completion needs a clear name and surrounding context.

Chat needs a well-framed question and the right files in scope.

PRD-driven needs a spec that defines the shape of the output before you ask for it.

---

In all three modes, the quality of your output is proportional to the quality of your input. The tools are not magic — they amplify what you give them.

---

## Summary

1. **Inline** — use when you're writing and want completion. Give it signal: method names, comments, patterns.
2. **Chat** — use when you're thinking. Explore, explain, design, generate larger pieces.
3. **PRD-driven** — use when you're building a feature. Write the spec first; generate in layers.

The goal is not to use AI more. It's to use the right mode for the right task — and stay in control of the output.

---

# Questions?

_Module 4 — Three Ways to Work with AI_
