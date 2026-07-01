# AI-Assisted Laravel/PHP Development

**Module 3 — GitHub Copilot for Developers**

---

## Learning objectives

By the end of this module you will be able to:

- Use AI to generate boilerplate, Eloquent models, and service layers in Laravel 11
- Use AI to explain legacy code and unfamiliar codebases
- Apply refactoring strategies with AI: modernizing code safely
- Generate unit tests (Pest/Mockery) with AI assistance
- Evaluate AI output for correctness, style, and fit before applying

---

## Bridge from Module 2

**What we learned last time:**

- **How** to prompt effectively (clarity, context, constraints)
- Zero-shot, few-shot, chain-of-thought techniques
- Iterative refinement

---

**The problem:**

- ❌ You know how to prompt, but what should you ask for?
- ❌ How do I explain legacy code I don't understand?
- ❌ Can AI help me refactor safely?
- ❌ How do I generate tests that actually work?

**Today:** Learn **what** to prompt for in Laravel/PHP development.

---

## Code generation: the problem

**Scenario:** You need a Book Eloquent model with migration, repository, and service method

---

**Manual approach:**

- ❌ Write model, create migration, create repository, write service method
- ❌ Time-consuming: 15-20 minutes for boilerplate
- ❌ Error-prone: Easy to miss fillable fields, wrong return types

**Result:** Slow, repetitive, error-prone

---

## Code generation: the solution

**AI approach:**

- ✅ Generate complete model with proper migration
- ✅ Fast: 30 seconds vs. 15 minutes
- ✅ Consistent: Follows Laravel patterns

---

**Prompt example:**

> "Generate a Laravel 11 Eloquent model for a Book with fields: id (bigint, primary key), title (string), author (string), isbn (string, unique), published_year (int). Use PHP 8.3 and include the migration."

---

## Code generation: progressive building

**Start simple:**

1. Model and migration only
2. Add repository class
3. Add service class with constructor injection
4. Add controller with REST endpoint

**Build incrementally** — don't ask for everything at once.

---

## Code generation: refinement

**Initial output** (maybe uses facades):

```php
use Illuminate\Support\Facades\DB;

$books = DB::table('books')->get();
```

---

**Refine prompt:**

> "Use constructor injection via the Laravel container, not facades"

**Improved output:**

```php
public function __construct(
    private readonly BookRepository $repository,
) {}
```

**Key point:** Review and refine iteratively.

---

## When to generate vs. write manually

| Generate with AI             | Review carefully          | Write manually     |
| ---------------------------- | ------------------------- | ------------------ |
| Boilerplate (models, DTOs)   | Business logic            | Security/auth      |
| CRUD operations              | Complex algorithms        | Payment processing |
| Repository classes           | Performance-critical code | Compliance code    |
| Service stubs                |                           |                    |

---

## Code explanation: the problem

**Scenario:** You inherited a pre-framework PHP class you don't understand

**Problems:**

- ❌ Hard to read: Old patterns, verbose syntax
- ❌ No documentation: Why was it written this way?
- ❌ Risk: Don't know what it does or what breaks if changed

---

**Result:** Fear of touching legacy code

---

## Code explanation: the solution

**Prompt example:**

> "Explain what this code does step by step. Why might it have been written this way? What are the dependencies?"

---

**AI provides:**

- ✅ Functional explanation
- ✅ Historical context
- ✅ Dependency analysis
- ✅ Modern equivalent suggestions

---

## Code explanation: layers of understanding

**Layer 1:** "What does this do?" (functional explanation)

**Layer 2:** "Why was it written this way?" (historical context)

**Layer 3:** "What's the modern equivalent?" (migration path)

**Layer 4:** "What are the risks if I change it?" (dependency analysis)

---

**Progressive building:** Start with "what," build to "how to modernize."

---

## Refactoring: the problem

**Example:** Procedural method with loops, null checks, verbose logic

**Problems:**

- ❌ Hard to read: Nested loops, multiple null checks
- ❌ Not modern: PHP 8.3 features not used
- ❌ Error-prone: Easy to introduce bugs

**Result:** Code that works but is hard to maintain

---

## Refactoring: the solution

**Prompt example:**

> "Refactor this method to use Laravel collections and PHP 8.3 type hints. Extract null checks into filters. Improve readability while maintaining the same behavior."

**AI suggests:**

- ✅ Collection-based refactor
- ✅ More readable: Functional style
- ✅ Modern: Uses PHP 8.3 features

---

## Refactoring strategies

**Strategy 1:** Extract method (break down large methods)

**Strategy 2:** Replace loops with collections

**Strategy 3:** Add type hints and match expressions

**Strategy 4:** Improve naming and structure

**Progressive building:** Start with one strategy, add more as needed.

---

## Refactoring: safety first

**Always:**

- ⚠️ Run tests before and after
- ⚠️ Review the diff carefully
- ⚠️ Verify behavior hasn't changed

**Example:** Refactor that breaks a test → fix it → tests pass

**Key point:** Refactoring is safe when you have tests.

---

## When to refactor with AI

| Good for AI refactoring  | Be careful                | Don't use AI             |
| ------------------------ | ------------------------- | ------------------------ |
| Readability improvements | Performance-critical code | Security-sensitive logic |
| Modernizing syntax       |                           |                          |
| Extracting methods       |                           |                          |
| Reducing duplication     |                           |                          |

---

## Unit testing: the problem

**Scenario:** You need tests for a service method

**Manual approach:**

- ❌ Write test file, set up mocks, write assertions
- ❌ Time-consuming: 10-15 minutes per test method
- ❌ Easy to miss: Edge cases, null handling

**Result:** Tests are written slowly or skipped

---

## Unit testing: the solution

**Prompt example:**

> "Generate Pest tests with Mockery for this service method. Cover happy path, null input, and empty string scenarios. Use PHP 8.3."

---

**AI generates:**

- ✅ Complete Pest test file
- ✅ Includes Mockery setup
- ✅ Covers multiple scenarios

---

## Unit testing: progressive quality

**Level 1:** Basic test (happy path only)

**Level 2:** Add edge cases (null, empty, exceptions)

**Level 3:** Add dataset tests

**Level 4:** Add feature test suggestions

**Build from basic to comprehensive.**

---

## Unit testing: running and fixing

**Generated test** → Run it → One test fails

**Diagnosis:** What's wrong? (maybe mock not set up correctly)

**Refine prompt:**

> "Fix the Mockery setup for the repository"

---

**Re-run** → Tests pass

**Key point:** Tests are iterative too — generate, run, refine.

---

## Test best practices

**Cover:**

- ✅ Happy path
- ✅ Edge cases (null, empty, exceptions)
- ✅ Proper mocking (Mockery)
- ✅ Clear assertions with Pest `expect()`

**Verify:**

- ⚠️ Tests actually test the right thing
- ⚠️ Don't trust tests without running them

---

## Review before paste (or accept): the problem

**Example:** AI generates code with wrong API

**Problems:**

- ❌ Wrong version: Uses Laravel 10 patterns instead of 11
- ❌ Wrong patterns: Doesn't match team style
- ❌ Security issue: Missing validation

**Result:** Code that doesn't work or introduces bugs

---

## Review before paste: evaluation checklist

**Before applying AI output, check:**

- ✅ **Correctness:** Does it run? Does it work?
- ✅ **Version:** Right Laravel/PHP version?
- ✅ **Style:** Matches team conventions?
- ✅ **Security:** No obvious vulnerabilities?
- ✅ **Tests:** Can I test this?

---

## Common issues to spot

**Wrong API versions:**

- Laravel 10 vs. 11 APIs
- Older PHP patterns vs. PHP 8.3 features

---

**Deprecated patterns:**

- Facades vs. constructor injection
- Raw SQL vs. Eloquent query builder

---

**Security issues:**

- SQL injection risks
- Missing validation
- Mass assignment vulnerabilities

---

**Performance problems:**

- N+1 queries
- Inefficient algorithms

---

## When to reject AI output

**Reject if:**

- ❌ Wrong version or API
- ❌ Doesn't match team style
- ❌ Security concerns
- ❌ Too complex or unclear
- ❌ Better to write manually

**Remember:** AI assists, but you're responsible for the code.

---

## Summary

1. **Generation:** Boilerplate, models, services — fast and consistent
2. **Explanation:** Legacy code, unfamiliar patterns — understand before changing
3. **Refactoring:** Modernize safely — always test before/after
4. **Testing:** Generate tests — run and refine iteratively
5. **Review:** Always evaluate before applying — correctness, version, style, security

---

## Bridge to Module 4

**What we've learned:**

- **What** to prompt for in Laravel/PHP development (generation, explanation, refactoring, testing)

**What's next:**

**Module 4:** Tooling Strategies — IDE integrations, chat tools, workflow optimization.

Apply generation, explanation, refactoring, and testing throughout.

---

# Questions?

_Module 3 — AI-Assisted Laravel/PHP Development_
