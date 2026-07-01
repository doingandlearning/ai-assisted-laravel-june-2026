# SDLC Integration

**Afternoon session — AI-Assisted Development for Laravel Teams**

<!-- end_slide -->

## Opening scenario

A developer on your team has just used AI to generate a complete `LoanService` — model, repository, service, and controller. It took three minutes.

They're about to paste it into the codebase.

**Type in chat: what do you check before you let that go in?**

<!-- end_slide -->

## AI across the full development lifecycle

This isn't just a code generation tool.

<!-- incremental_lists: true -->
- **Requirements and planning** — turning rough ideas into structured specs
- **Code generation** — boilerplate, models, services, controllers
- **Refactoring** — modernising code safely toward current patterns
- **Code review** — a first pass before human review
- **Documentation** — PHPDoc, inline comments, ADRs
- **Test writing** — Pest suites, edge cases, dataset tests

<!-- pause -->

Each one has a failure mode. Today is about using them well — and knowing when not to.

<!-- end_slide -->

## Requirements and planning

AI is useful before you write a line of code.

**Turning a rough idea into a structured spec:**
```
We need an endpoint that lets a user archive a task they own.
Stack: Laravel 11, PHP 8.3.
Turn this into a PRD with endpoint definition, behaviour list, and acceptance criteria.
```

<!-- pause -->

**What this produces:** a draft spec ready for review, with error cases and edge cases the developer might not have listed.

**What you still own:** the decision about whether the spec is correct. AI generates plausible requirements — business context is still yours.

<!-- end_slide -->

## Code generation: what it's good for

Fast, consistent boilerplate: Eloquent models, migrations, repository classes, service stubs, CRUD controllers.

The risk isn't that AI generates the wrong thing. It's that it generates the right pattern for the **wrong version** of your stack.

<!-- pause -->

**Demo:** *(Generate a Book model without specifying a version — show what comes back. Then add "Laravel 11, PHP 8.3, constructor injection throughout" and compare. Ask the group: what specifically changed?)*

<!-- end_slide -->

## Code generation: build incrementally

Don't ask for everything in one prompt.

Start with the model. Review it. Then add the repository. Review it. Then the service.

<!-- pause -->

Each step is a checkpoint. If the model uses the wrong fillable fields, fix it before the repository inherits the same mistake across three files.

<!-- pause -->

**The rule of thumb:** the longer the output, the less you'll read it carefully. Keep generation prompts scoped to one layer at a time.

<!-- end_slide -->

## When to generate, when to write

| Generate with AI | Review carefully | Write manually |
|---|---|---|
| Models, migrations, repository classes | Business logic with edge cases | Security and auth logic |
| CRUD operations | Performance-critical paths | Payment and compliance code |
| Service stubs | Complex algorithms | Anything your team will be audited on |

<!-- pause -->

**Discussion:** your team has a `PricingService` with complex discount logic that's been stable for two years. A junior asks if they can use AI to add a new discount tier. What do you tell them?

<!-- end_slide -->

## Explanation: the layered approach

When you encounter code you don't understand, don't ask "what does this do?" in one shot.

Build understanding in layers:
<!-- incremental_lists: true -->
1. **What does it do?** — functional behaviour, input/output
2. **Why was it written this way?** — historical context, patterns of the era
3. **What's the modern equivalent?** — migration path
4. **What breaks if I change it?** — dependencies, callers, assumptions baked in


Each layer changes what you'd do next. Layer 4 is the one most people skip — and the one that causes the most incidents.

<!-- end_slide -->

## Explanation: the question that matters most

Of the four layers, layer 4 is the one AI is most likely to get wrong.

"What breaks if I change it?" requires knowledge of your actual codebase — callers, contracts, downstream consumers — that the model doesn't have unless you provide it.

<!-- pause -->

**This means:** use AI for layers 1–3. For layer 4, use AI to generate the *questions to ask*, then answer them yourself by reading the code.

<!-- end_slide -->

## Refactoring: safety first

The only safe refactor is one that has tests before and after.

<!-- incremental_lists: true -->
**The sequence:**
1. Ask AI to generate tests for the existing code
2. Run them — they should pass
3. Ask AI to refactor
4. Run the tests again — they should still pass
5. Read the diff: does the behaviour match?


If step 2 fails — the tests AI generated don't pass against the existing code — stop. The tests are wrong, or the code is already broken. Either way, don't refactor until you understand which.

<!-- end_slide -->

## Refactoring: what AI is and isn't good at

Good at: mechanical transformations — foreach to collections, manual null checks to typed filters, extracting repeated logic into a method.

<!-- pause -->

Less reliable at: knowing which behaviour is intentional versus accidental. A null check that looks defensive might be load-bearing. AI will refactor it away confidently.

<!-- pause -->

**The question to ask after every refactor:** "Is there anything in the original code that looked wrong but was actually doing something important?" If you can't answer that, you need layer 4 of the explanation first.

<!-- end_slide -->

## Code review: AI as a first pass

Before sending to a colleague for review, use AI to catch the obvious.

```
Review this controller method for:
- Missing validation
- Incorrect HTTP status codes
- N+1 query risks
- Missing null checks
- Deviation from Laravel conventions (constructor injection, Form Requests, JsonResponse)
```

<!-- pause -->

**What this gets you:** a fast filter for the mechanical issues — version mismatches, missing guards, wrong return types.

**What it doesn't replace:** human judgement on architecture, security audit, business logic correctness, and whether the feature is actually doing what it should.

<!-- end_slide -->

## Code review: what to explicitly ask for

AI code review is as good as the instructions you give it.

| Ask for | Because |
|---|---|
| Security issues — missing validation, raw SQL, mass assignment | These are pattern-recognisable |
| Version-specific patterns — `$dates` vs `$casts`, facade vs injection | These are detectable with version context |
| N+1 risks — missing `with()`, queries in loops | These are structural and visible |
| Test coverage gaps | AI can compare your tests against your method's branches |

<!-- pause -->

**What not to rely on it for:** knowing your business rules. It doesn't know what a task is *supposed* to do — only what the code *does* do.

<!-- end_slide -->

## Documentation

AI produces documentation quickly. The risk is volume without value.

**PHPDoc that's useful:**
```
Generate PHPDoc for this service method.
Focus on: what the parameters mean in business terms, what the return value represents, and what exceptions are thrown and why.
Do not just describe the types — those are already in the signature.
```

<!-- pause -->

**ADRs and inline comments:**
```
Write a short ADR explaining why we chose the repository pattern for this module
rather than using Eloquent directly in the service.
```

<!-- pause -->

The constraint matters: "Do not just describe the types" stops AI from producing documentation that restates what the signature already says.

<!-- end_slide -->

## Test writing: generate, run, refine

AI-generated tests fail more often than people expect — not because the test logic is wrong, but because Mockery setup is fiddly and the model doesn't always get it right first time.

<!-- incremental_lists: true -->
**The workflow:**
1. Generate — specify Pest, Mockery, the scenarios you want covered
2. Run — don't assume they pass
3. Diagnose — a failing test is a prompt refinement opportunity, not a failure
4. Refine — add the missing setup or constraint and re-generate


**The thing not to do:** read the tests, think they look right, and skip running them. Tests that look correct and fail are the most dangerous output AI produces.

<!-- end_slide -->

## Test writing: what scenarios to ask for

Don't just ask for "tests for this method." Name the scenarios explicitly.

<!-- incremental_lists: true -->
- Happy path with valid input
- Null input — what should happen?
- Empty string or empty collection
- Repository returns null (record not found)
- Repository throws an exception
- Ownership check fails (403, not 404)


**Then add one the model won't think of.** For `findBookByIsbn`: what happens with a valid-format ISBN that has leading whitespace? The guard clause uses `trim($isbn) === ''` — does the model test for that explicitly?

<!-- end_slide -->

## Establishing team conventions

AI produces consistent output when given consistent constraints. The inverse is also true: if everyone on the team prompts differently, everyone gets different output.

**The conventions worth codifying:**

<!-- incremental_lists: true -->
- Injection style — constructor injection, never `app()` helper
- Return types — `JsonResponse` for all API controllers
- Validation location — Form Requests, never inline in controllers
- Repository pattern — interfaces in `App\Repositories\Contracts\`
- Test framework — Pest, Mockery, never `TestCase` classes
- Naming — what your team calls things (services, DTOs, actions, etc.)

<!-- end_slide -->

## Conventions in practice

Once you have a list, encode it somewhere:

**Option 1: `.github/copilot-instructions.md`**
Copilot reads this for every Chat conversation. Good for baseline standards.

**Option 2: Prompt templates in the repository**
A `/prompts/` directory with standard templates for "generate a service", "generate a Pest test suite", etc. Anyone can pick up a template and fill in the specifics.

**Option 3: AGENTS.md**
If you're running agentic tools, this file tells them your conventions. We'll cover agents this afternoon.

<!-- pause -->

**The goal:** a new team member prompting AI for a controller gets the same output as a senior developer prompting AI for a controller. Not because the AI is smart — because the constraints are shared.

<!-- end_slide -->

## Security guardrails

There is a category of code you do not generate with AI, no matter how good the prompt.

<!-- incremental_lists: true -->
**Always write manually:**
- Authentication and authorisation logic
- Password hashing, token generation, session handling
- Payment processing and financial calculations
- Anything your team will be audited on
- Compliance-gated features (GDPR, PCI, HIPAA)


<!-- pause -->

This is not because AI can't produce plausible code for these areas. It's because the cost of a subtle error is catastrophic, and plausible-but-wrong is the failure mode you can't catch without running it.

<!-- end_slide -->

## What not to send to AI

Even with enterprise tooling, some things should not leave your terminal.

<!-- incremental_lists: true -->
**Never send:**
- Credentials, API keys, connection strings (even with values redacted — the structure reveals information)
- Real customer data, PII, personal health information
- Internal system architecture you wouldn't publish externally
- Production database schemas with real table/column names in sensitive contexts


<!-- pause -->

**The rule:** treat enterprise AI like a senior contractor with an NDA — not like a trusted colleague of ten years. They're under contract, but you still don't hand them the keys.

<!-- end_slide -->

## The evaluation checklist

Before any AI-generated code goes into the codebase:

<!-- incremental_lists: true -->
- Does it run?
- Is it the right Laravel and PHP version?
- Does it match the team's injection and naming conventions?
- Are there any obvious security issues — missing validation, raw SQL, unguarded mass assignment?
- Is there a test for it, or can one be written?
- Does it do what the spec said it should do?


**Back to the opening scenario.** Your colleague is about to paste in that `LoanService`.

You now have six questions. Which one do you ask first?

<!-- end_slide -->

## Summary

1. **Plan**: AI can draft specs and requirements — you validate the business logic
2. **Generate**: incrementally, one layer at a time; review each before adding the next
3. **Explain**: in layers — functional, historical, modern equivalent, then what breaks
4. **Refactor**: safely — tests before and after; read the diff; question what looks accidental
5. **Review**: AI for the mechanical pass; humans for the judgement call
6. **Document**: give it constraints; documentation that restates types is not useful
7. **Test**: generate, run, diagnose, refine; never trust without running
8. **Conventions**: encode them; shared constraints produce consistent output
9. **Security**: some code is always written manually; some data is never sent

<!-- end_slide -->

## What's next

**This afternoon:** The Art of the Possible — agents, Model Context Protocol, multi-agent workflows, and where the Laravel ecosystem is heading.

The conventions and standards from this session are what make agentic workflows possible. An agent needs the same constraints as a prompt — but it's running them autonomously.

<!-- end_slide -->

# Questions?

*Afternoon session — SDLC Integration*
