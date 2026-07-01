# Module 3: AI-Assisted Laravel/PHP Development (Core Focus)

## Learning objectives

- Use AI to generate boilerplate, Eloquent models, migrations, and service layers in Laravel applications.
- Use AI to explain legacy code (e.g. pre-framework PHP, procedural classes) and unfamiliar codebases.
- Apply refactoring strategies with AI: modernising code and improving readability with PHP 8.3 idioms.
- Generate unit tests (Pest/Mockery) for Laravel applications with AI assistance.
- Evaluate AI output for correctness, style, and fit before applying it.

## Suggested talking points

- Code generation: when to ask for full snippets vs. incremental changes; models, DTOs, services.
- Code explanation: prompting for "what does this do?" and "why was it written this way?" for legacy.
- Refactoring: clear instructions (e.g. "extract method," "use collections," "add type hints and match expressions").
- Unit testing: structuring prompts for Pest/Mockery; covering edge cases and mocks.
- Review before paste: spot wrong APIs, outdated patterns, and security issues.

## Suggested demos

- **Laravel:** Generate an Eloquent model + repository + simple service from a short spec; show one refinement round.
- **Legacy:** Paste a short legacy procedural PHP snippet; get an explanation and a "modern equivalent" summary.
- **Refactor:** Take a procedural or verbose method; ask for a refactor (e.g. collections, type hints, match expressions); apply and compare.
- **Tests:** Generate Pest/Mockery tests for a service method; run them and fix one failure by refining the prompt.

## Suggested exercises

- **Generate:** From a 2–3 sentence spec, generate a small CRUD service (model + repo + service method); run it.
- **Explain:** Bring (or use provided) legacy snippet; get an explanation and list of risks/dependencies.
- **Test:** Pick one existing method; generate tests; run and extend with one edge case.
- **Refactor:** Choose one method from your codebase (or provided); refactor with AI; review diff and discuss what you'd change.

## Suggested running time

90–120 minutes (anchor module; allow time for hands-on)
