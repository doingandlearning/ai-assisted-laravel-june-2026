# The Art of the Possible

**Late afternoon session — AI-Assisted Development for Laravel Teams**

<!-- end_slide -->

## Where we've been

This morning: shared vocabulary, how LLMs work, prompting principles, context as code.

Late morning: Copilot surfaces — inline, Chat, terminal, PRD-driven development.

This afternoon: AI across the full SDLC, team conventions, security guardrails.

<!-- pause -->

**Now:** what comes next — and how it connects to the work you're already doing.

<!-- end_slide -->

## What is an agent?

A prompt tells an AI what to do. An agent is an AI that decides what to do next, and then does it, repeatedly, until a goal is met.

<!-- pause -->

**The difference:**

| Prompt | Agent |
|---|---|
| You describe a task | You describe a goal |
| AI produces output | AI takes a series of actions |
| You evaluate the output | AI evaluates its own progress |
| One round trip | Multiple steps, loops, and decisions |

<!-- pause -->

An agent can read files, run commands, make API calls, write code, run tests, and decide what to try next based on the result.

<!-- end_slide -->

## What agents can do in a development context

<!-- incremental_lists: true -->
- Read your codebase and understand its structure
- Write code to a file
- Run tests and read the output
- Fix failing tests and rerun
- Make a series of edits across multiple files
- Call external tools and APIs
- Ask for clarification when stuck


<!-- pause -->

This is qualitatively different from getting a suggestion in your editor. The agent is working — not suggesting.

<!-- end_slide -->

## Agentic workflows in practice

**A simple example:**

> "Add a new endpoint to the Tasks API: POST /api/tasks/{id}/duplicate. It should copy the task, assign it to the requesting user, and return the new task. Follow the existing conventions. Write the tests."

<!-- pause -->

An agent with access to your codebase:
1. Reads the existing `TaskController` and `TaskService`
2. Reads the repository interface
3. Writes the service method
4. Writes the Form Request
5. Writes the controller endpoint
6. Writes the Pest tests
7. Runs the tests
8. Fixes any failures
9. Reports back

You review the result. You don't manage each step.

<!-- end_slide -->

## The human role in an agentic workflow

More oversight at the beginning. Less in the middle. More at the end.

<!-- incremental_lists: true -->
- **Before**: write a clear goal, set the constraints, define what done looks like
- **During**: monitor progress; intervene if the agent is going in the wrong direction
- **After**: review the output as you would a pull request from a colleague


<!-- pause -->

The review is non-negotiable. An agent that produces working code is still producing code you're responsible for. "The agent wrote it" is not a defence in a security audit.

<!-- end_slide -->

## Exercise: Write the goal, not the steps

Think of a small feature you've built manually before.

Write it as a goal statement for an agent: the outcome, the constraints, and what "done" looks like. Don't list implementation steps — that's the agent's job.

**Type in chat:** one constraint you had to spell out that you'd never need to say to a human colleague on your team.

<!-- end_slide -->

## Where agents go wrong

Agents fail in predictable ways:

<!-- pause -->

**Goal misinterpretation** — the agent interprets "add an endpoint" more broadly than intended and restructures the controller.

<!-- pause -->

**Context hallucination** — the agent assumes conventions it can't see (because they're not in a context file) and produces inconsistent output.

<!-- pause -->

**Runaway loops** — the agent keeps trying to fix failing tests without making progress, burning tokens.

<!-- pause -->

**Scope creep** — the agent "notices" something else while working and "helpfully" changes it.

<!-- pause -->

**Mitigations:** clear goals, well-defined context files (AGENTS.md), explicit scope boundaries, checkpoints for human review.

<!-- end_slide -->

## Exercise: Spot the failure mode

Match each scenario to a failure mode from the last slide — goal misinterpretation, context hallucination, runaway loops, or scope creep.

<!-- incremental_lists: true -->
1. Asked to fix a failing test, the agent is still trying twenty minutes later and the test still fails
2. The agent added a `deleted_at` column and soft-delete logic nobody asked for, "since it seemed like good practice"
3. The agent assumed the project uses Eloquent's default timestamps — this team disabled them everywhere

**Type in chat:** your answers for 1–3.

<!-- end_slide -->

## Model Context Protocol (MCP)

A standard that lets AI models connect to external tools and data sources in a structured, secure way.

<!-- pause -->

**Without MCP:**
The model knows what you put in the prompt. If you want it to know your database schema, your API docs, or your monitoring data — you paste it in manually.

**With MCP:**
A server exposes your tools and data through a standard interface. The model can query it on demand — reading your schema, calling your APIs, checking your logs.

<!-- pause -->

**The analogy:** MCP is to AI models what REST is to web services. It's not a tool — it's a protocol that makes tools connectable.

<!-- end_slide -->

## What MCP enables

```
User: "What are the slowest endpoints in the Tasks API over the last 24 hours?"

Without MCP: you paste the logs in, manually.

With MCP + a monitoring server:
  → Model queries your Datadog/CloudWatch MCP server
  → Gets the data
  → Analyses it
  → Returns an answer grounded in real data
```

<!-- pause -->

For a Laravel team:

- **Database MCP server**: the model can read your schema without you pasting it
- **GitHub MCP server**: the model can read PRs, issues, and comments
- **Laravel docs MCP server**: the model queries current docs rather than training data
- **Your own API MCP server**: the model can call your own endpoints as part of an agentic workflow

<!-- end_slide -->

## Building an MCP server

An MCP server is a lightweight process that exposes tools and resources through the MCP protocol.

A PHP/Laravel team can build one in Laravel:

```php
// A simple MCP tool: query the tasks database schema
Tool::register('get_schema', function (string $table): array {
    return Schema::getColumnListing($table);
});

// A simple MCP resource: the team's coding conventions
Resource::register('conventions', function (): string {
    return file_get_contents(base_path('.github/copilot-instructions.md'));
});
```

<!-- pause -->

The model can now call `get_schema('tasks')` during an agentic workflow — without you pasting the schema into every prompt.

**This is on the follow-on topics list for a reason.** If this interests the team, there's a dedicated half-day session for building a custom MCP server against your own infrastructure.

<!-- end_slide -->

## Multi-agent patterns

A single agent does one thing at a time. Multiple agents can work in parallel, check each other's work, or specialise.

**Orchestrator + workers:**
One agent breaks a goal into subtasks and delegates. Worker agents execute independently. The orchestrator collates results.

<!-- pause -->

**Critic pattern:**
One agent writes the code. A second agent reviews it against a set of criteria — security, conventions, test coverage. The first agent revises based on the critique.

<!-- pause -->

**Specialist agents:**
A requirements agent. A code agent. A test agent. A documentation agent. Each has a narrow context and a clear role.

<!-- pause -->

These patterns are emerging. They're not yet standard tooling. But they're the direction — and understanding the pattern now means you'll recognise it when the tools arrive.

<!-- end_slide -->

## TDD with an agent harness

Test-Driven Development with an agent changes the feedback loop.

**Traditional TDD:**
1. Write a failing test
2. Write code to make it pass
3. Refactor
4. Repeat

**TDD with an agent:**
1. Write a failing test (you)
2. Give the agent the test and the goal
3. The agent writes code, runs the test, iterates until green
4. You review the result

<!-- pause -->

The tests become your specification. The agent interprets them as a definition of done.

<!-- pause -->

**The catch:** the agent can write code that passes the tests without doing what you intended, if the tests are underspecified. Writing good tests is still a human skill.

<!-- end_slide -->

## TDD with an agent: in practice

```
Here is a failing Pest test:

it('returns 403 when archiving a task owned by another user', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $task = Task::factory()->for($owner)->create();

    actingAs($other)
        ->patchJson("/api/tasks/{$task->id}/archive")
        ->assertStatus(403);
});

The test is failing because the endpoint doesn't exist yet.
Implement the endpoint. Follow the existing conventions in TaskController.php.
Do not touch the test.
```

The agent reads `TaskController.php`, implements the endpoint, runs the test, and iterates.

<!-- end_slide -->

## Exercise: Write a failing test for an agent

Pick a small piece of behaviour you haven't built yet — real or invented.

Write one Pest test that would fail because the feature doesn't exist. Make it specific enough that passing it *means* the feature is correct, not just present.

**Type in chat:** is there any way the test could pass with obviously wrong code? If so, tighten it.

<!-- end_slide -->

## Where the Laravel ecosystem is heading

**Today:**
- Copilot for inline and Chat assistance
- Agent tools (Cursor, Cline, OpenCode, Claude Code) for file-level agentic tasks
- MCP servers for connecting models to external tools and data

<!-- pause -->

**Near term:**
- MCP becoming a standard across Laravel tooling — Forge, Vapor, Envoyer MCP servers possible
- Agentic code review as part of the PR workflow
- Agent harnesses for automated regression and refactoring pipelines

<!-- pause -->

**Longer term:**
- Multi-agent workflows embedded in CI/CD
- Retrieval-augmented code generation — models that query your actual codebase, not just open files
- AI-assisted architecture decisions grounded in your real system

<!-- end_slide -->

## What changes for your team

The transition from prompt engineering to agentic development is a change in what you need to be good at.

<!-- pause -->

**Less important:** writing the perfect prompt for a single task.

**More important:**
- Defining goals clearly enough for an agent to pursue them
- Writing tests that specify behaviour precisely enough to serve as agent acceptance criteria
- Maintaining context files that give agents the constraints they need
- Reviewing agentic output as you would any production code

<!-- pause -->

**The fundamentals don't change.** You still need to understand the code. You still need to verify the output. You still own the result.

The speed increases. The responsibility doesn't.

<!-- end_slide -->

## The team standard question

Before the day ends: the team needs a shared answer to three questions.

<!-- incremental_lists: true -->
1. **Where is the line?** Public vs. enterprise AI — what's the policy, and is it written down?
2. **What are the shared constraints?** Injection style, return types, validation location, testing framework — are they encoded?
3. **What's always manual?** Auth logic, payment code, compliance features — is the list agreed and visible?


<!-- pause -->

These don't have to be perfect today. They need to exist, be shared, and be revisited.

<!-- end_slide -->

## Summary

1. **Agents** — AI that takes actions toward a goal, not just produces output in response to a prompt
2. **Agentic workflows** — clear goals, good context files, human review at the end
3. **MCP** — a standard protocol for connecting AI models to your tools and data sources
4. **Multi-agent patterns** — orchestrators, critics, specialists — emerging patterns worth understanding now
5. **TDD with agents** — tests as specification; agents as implementers; humans as the judges
6. **The Laravel ecosystem** — MCP servers, agentic tooling, and retrieval-augmented generation are coming
7. **The fundamentals** — speed increases, responsibility doesn't

<!-- end_slide -->

## What's available next

If this session has opened questions the team wants to pursue:

| Topic | What it covers |
|---|---|
| Building an MCP Server | Design and build a custom MCP server for your own tools and data |
| RAG for Laravel | Add your own data to LLM responses — useful for internal tooling and domain-specific code |
| OWASP LLM Top 10 | Prompt injection, data leakage, insecure output handling — building defensively when AI is in your product |
| Evaluations and Testing AI Features | How to test AI-powered features reliably as models and prompts evolve |
| AI Product Integration Patterns | Embedding AI features in existing products — UX, latency, fallback, humans in the loop |

<!-- end_slide -->

# Thank you

*Late afternoon session — The Art of the Possible*

*AI-Assisted Development for Laravel Teams*
*Kevin Cunningham — kevin@kevincunningham.co.uk*
