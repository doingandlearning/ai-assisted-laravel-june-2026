---
name: behavior-safe-refactor
description: 'Refactor existing code while preserving behavior, public interface, and return values. Use when you want focused cleanup with strict safety constraints and minimal edits. Triggers: "refactor this code", "clean up without changing behavior", "improve readability only", "reduce duplication safely".'
argument-hint: 'Language + code + prioritized goals. Example: "Language: C#. Primary: reduce duplication. Secondary: improve naming. Tertiary: reduce allocations. Constraints: no API changes, minimal edits, inline why-comment on each changed line. Code: ..."'
user-invocable: true
metadata:
  version: 1.0.0
  team: backend
---

# Behavior-Safe Refactor

## What This Skill Produces

- A minimal, behavior-preserving refactor of the provided code.
- No changes to public interface, return values, or externally observable behavior.
- Refactor changes aligned to explicit priority goals.
- A short inline comment on each changed line explaining why that line changed.

## When to Use

- Improve readability, structure, or maintainability without feature changes.
- Reduce duplication while preserving the current contract.
- Do low-risk performance cleanup that does not alter results or API shape.

## Inputs You Should Provide (Best Results)

- Language.
- Goals in priority order:
  1. Primary goal.
  2. Secondary goal.
  3. Tertiary goal.
- Constraints:
  - Keep changes minimal.
  - Add a short inline why-comment on each changed line.
  - Do not add dependencies.
  - Do not change module structure.
- Code to refactor.

If one or more inputs are missing, ask at most 2 clarifying questions, then proceed with safe defaults.

## Procedure

### 1) Freeze the Contract Before Editing

1. Identify public surface and behavior boundaries:
   - Public method/function names and signatures.
   - Return types, returned values, and error behavior.
   - Side effects and state transitions.
2. List non-negotiables from constraints in the working plan.

Quality gate:

- Contract boundaries are written down before edits begin.

### 2) Plan the Smallest Useful Refactor

1. Select edits that directly serve the highest-priority goal first.
2. Only include secondary/tertiary changes if they are low-risk and local.
3. Reject any edit that requires dependency or module-structure changes.

Quality gate:

- Every planned change maps to a stated goal.
- No planned change expands the public contract.

### 3) Apply Minimal Refactor Slices

1. Make small, local edits in the tightest scope possible.
2. Keep names/signatures/return semantics unchanged unless purely internal and proven safe.
3. Add a short inline why-comment on each changed line.
4. Avoid broad rewrites and formatting-only churn.

Quality gate:

- Diff stays focused on goal-related lines.
- Changed lines include concise why-comments.

### 4) Validate Behavioral Equivalence

1. Run existing tests if available.
2. If tests are unavailable, perform direct before/after reasoning on:
   - Input-to-output mapping.
   - Edge-case handling.
   - Exceptions and null/empty behavior.
3. Verify no public API or module-structure changes were introduced.

Quality gate:

- Behavior is equivalent for all known paths.
- Public interface and returns are unchanged.

### 5) Report Clearly

Provide:

- What changed and why (mapped to primary, secondary, tertiary goals).
- Evidence behavior is preserved (tests or reasoning).
- Any constraints that limited further cleanup.

## Decision Points (Branching)

### If a Goal Conflicts with Contract Safety

- Prioritize safety and contract preservation.
- Skip the conflicting change and explain why.

### If Inline Why-Comments Reduce Readability in the Target Language

- Keep comments short and local.
- Prefer end-of-line comments over block comments.
- Do not move comments away from changed lines.

### If No Tests Exist

- Use conservative refactors only.
- Add explicit equivalence reasoning in the report.
- Avoid complex transformations that cannot be validated confidently.

### If a Performance Tertiary Goal Requires Structural Change

- Do not implement if it changes module structure or risks behavior.
- Document it as a follow-up suggestion instead.

## Completion Checks

Before marking done, confirm all are true:

- Public interface is unchanged.
- Return values and behavior are unchanged.
- No new dependencies were introduced.
- Module structure is unchanged.
- Changes are minimal and goal-driven.
- Each changed line has a short inline why-comment.
- Validation evidence is included.

## Example Prompt

Refactor the following C# code. Do not change its behavior, public interface, or what it returns.

Goals, in priority order:

1. Reduce duplication.
2. Rename internal variables to better reflect intent.
3. Reduce unnecessary allocations.

Constraints:

- Keep changes minimal.
- Add a short inline comment on each changed line explaining why.
- Do not introduce new dependencies or change module structure.

[PASTE CODE HERE]
