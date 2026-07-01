---
name: strict-tdd
description: 'Follow a strict Test-Driven Development (TDD) workflow (red→green→refactor) to complete coding tasks. Use when you want tests written first, minimal implementation steps, frequent test runs, and disciplined refactoring. Triggers: "strict tdd", "TDD", "red green refactor", "tests first", "write failing test", "add regression test".'
argument-hint: 'Describe the behavior change + where tests live + how to run tests (e.g., "Add X; tests in src/__tests__; run: npm test")'
user-invocable: true
---

# Strict TDD (Red → Green → Refactor)

## What This Skill Produces
- One small, reviewable change at a time, each protected by a test.
- A regression test for every bug fix.
- A tight loop: failing test (red) → minimal fix (green) → cleanup (refactor) with tests always passing.

## When to Use
- Implementing new behavior where correctness matters.
- Fixing a bug and preventing regressions.
- Refactoring with confidence (tests as safety net).

## Inputs You Should Provide (Best Results)
- Target behavior (what should change, with an example input/output).
- Where tests should be added/edited.
- How to run a fast, focused test command (and the full suite command if different).

If any of these are missing, ask 1–2 clarifying questions max, then proceed.

## Procedure

### 0) Setup & Baseline
1. Identify the smallest increment of behavior to implement next.
2. Locate the closest existing test file/module to extend.
3. Establish the *fast path* test command:
   - Prefer one test file / one test name / one package.
   - If only a slow suite exists, still use it but keep increments even smaller.

**Quality gate:** You can run tests locally (or via the project’s standard task) and see results.

### 1) RED — Write the Failing Test First
1. Write a new test that expresses the next behavior increment.
2. Make the test fail for the right reason:
   - New behavior not implemented yet (preferred).
   - Or a precise assertion failure.
3. Run the smallest test selection that includes the new test.

**Quality gate:**
- The new test fails.
- Failure message is specific and understandable.
- No unrelated tests are changed “just because”.

### 2) GREEN — Minimal Implementation
1. Implement the smallest change to make the failing test pass.
2. Avoid unrelated refactors while getting to green.
3. Re-run the same focused test selection.

**Quality gate:**
- The new test passes.
- No new warnings/errors are introduced that indicate a likely correctness issue.

### 3) REFACTOR — Clean Up Safely
1. Improve readability/structure without changing behavior.
2. Remove duplication, rename for clarity, simplify logic.
3. Re-run tests after each refactor slice.

**Quality gate:**
- All tests still pass.
- Implementation is clearer than before.

### 4) Repeat in Small Steps
Repeat RED→GREEN→REFACTOR until the user-visible requirement is complete.

## Decision Points (Branching)

### If No Tests Exist Yet
Choose the lightest viable option:
- Add a small unit test harness for the module you’re changing.
- If that’s impossible quickly, add a minimal “characterization test” around current behavior before changing it.

Then proceed with RED→GREEN→REFACTOR.

### If Code Is Hard to Test
Prefer creating a seam rather than skipping tests:
- Extract a pure function.
- Introduce dependency injection (pass collaborators as parameters).
- Wrap external calls behind an interface/adapter.

Write a failing test against the seam, then proceed.

### If Tests Are Flaky
Do not “paper over” flakiness.
- First, reproduce and isolate: run the same test multiple times.
- Then fix determinism (time, randomness, network, concurrency) or scope the test away from nondeterministic dependencies.

Proceed only when the failing/passing signal is reliable.

### If Only Slow Integration Tests Exist
- Keep increments tiny (one assertion at a time).
- Prefer adding a small unit test layer near the code if feasible.

## Completion Checks
Before declaring the task done:
- The behavior is covered by tests (new or updated).
- Tests demonstrate the requirement (not just implementation details).
- Focused tests pass; then the project’s normal test suite/build passes (when available).
- No “drive-by” refactors.

## Output Format (How to Report Work)
- What test you added/changed and what it asserts.
- What minimal code change made it pass.
- What refactor (if any) you performed after green.
- What commands you ran to verify.

## Notes for Agents (Discipline Rules)
- Do not implement product behavior before a failing test exists, unless the user explicitly opts out of strict TDD.
- Keep diffs small; prefer multiple iterations over one big patch.
- If blocked (no test runner, missing deps), ask the user for the correct test command or environment expectation, then continue.
