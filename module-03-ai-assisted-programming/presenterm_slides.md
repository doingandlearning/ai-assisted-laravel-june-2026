# AI-Assisted Laravel/PHP Development

**Module 3 — GitHub Copilot for Developers**

<!-- end_slide -->

## Opening scenario

A developer on your team has just used AI to generate a complete `LoanService` — model, repository, service, and controller. It took three minutes.

They're about to paste it into the codebase.

**Type in chat: what do you check before you let that go in?**

- database migrations and basic security checks (RD)
- that the dev has fully reviewed and understood the code (NP)
- Security, standards (PM)
- sensitive info (BJ)
- checking code standards (TE)
- Security, meets standards, it's been understood by the dev (JR)
- Common security vulnerabilities; Whether it follows existing code standards/practices; Is it overengineered? (RF)
- It fulfils the functional requirements; Linting (JPT)
- Security, requirements  and code duplicates (SS)


<!-- end_slide -->

## Four things AI can do in your Laravel workflow
<!-- incremental_lists: true -->
1. **Generate** boilerplate you'd otherwise write by hand
2. **Explain** legacy code or patterns you don't recognise
3. **Refactor** existing code toward a modern style
4. **Test** by generating Pest/Mockery coverage for a method


Each one has a failure mode. Today is about using them well — and spotting when the output isn't good enough to use.

<!-- end_slide -->

## Generation: what it's good for

Fast, consistent boilerplate: Eloquent models, migrations, repository classes, service stubs, CRUD controllers.

The risk isn't that AI generates the wrong thing. It's that it generates the right pattern for the **wrong version** of your stack.

<!-- pause -->

**Demo:** *(Generate a Book model without specifying a version — show what comes back. Then add "Laravel 11, PHP 8.3, constructor injection throughout" and compare. Ask the group: what specifically changed?)*

<!-- end_slide -->

## Generation: build incrementally

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

**Discussion — type in chat:** your team has a `PricingService` with complex discount logic that's been stable for two years. A junior asks if they can use AI to add a new discount tier. What do you tell them?


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

## Testing: generate, run, refine

AI-generated tests fail more often than people expect — not because the test logic is wrong, but because Mockery setup is fiddly and the model doesn't always get it right first time.
<!-- incremental_lists: true -->
**The workflow:**
1. Generate — specify Pest, Mockery, the scenarios you want covered
2. Run — don't assume they pass
3. Diagnose — a failing test is a prompt refinement opportunity, not a failure
4. Refine — add the missing setup or constraint and re-generate


**The thing not to do:** read the tests, think they look right, and skip running them. Tests that look correct and fail are the most dangerous output AI produces.

<!-- end_slide -->

## Testing: what scenarios to ask for

Don't just ask for "tests for this method." Name the scenarios explicitly.
<!-- incremental_lists: true -->
- Happy path with valid input
- Null input — what should happen?
- Empty string or empty collection
- Repository returns null (book not found)
- Repository throws an exception


**Then add one the model won't think of.** For `findBookByIsbn`: what happens with a valid-format ISBN that has leading whitespace? The guard clause uses `trim($isbn) === ''` — does the model test for that explicitly?

<!-- end_slide -->

## The evaluation checklist

Before any AI-generated code goes into the codebase:
<!-- incremental_lists: true -->
- Does it run?
- Is it the right Laravel and PHP version?
- Does it match the team's injection and naming conventions?
- Are there any obvious security issues — missing validation, raw SQL, unguarded mass assignment?
- Is there a test for it, or can one be written?


**Back to the opening scenario.** Your colleague is about to paste in that `LoanService`.

You now have five questions. Which one do you ask first?


<!-- end_slide -->

## Summary

1. **Generate** incrementally — one layer at a time, review each before adding the next
2. **Explain** in layers — functional, historical, modern equivalent, then what breaks
3. **Refactor** safely — tests before and after, read the diff, question what looks accidental
4. **Test** iteratively — generate, run, diagnose, refine; never trust without running
5. **Review** before every paste — version, conventions, security, testability

<!-- end_slide -->

## Bridge to Module 4

**We've established:**
- What to prompt for in Laravel/PHP development
- How to evaluate output before it goes into your codebase

**Module 4**: Three ways to work with AI — inline completion, Copilot Chat, and PRD-driven development.

The evaluation checklist applies to output from all three.

<!-- end_slide -->

# Questions?

*Module 3 — AI-Assisted Laravel/PHP Development*
