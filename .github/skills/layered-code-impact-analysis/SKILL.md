---
name: layered-code-impact-analysis
description: 'Understand a code path in layers from local function behavior to system-wide blast radius. Use for reading unfamiliar code, incident triage, safe refactors, and dependency risk checks. Triggers: "understand this code", "explain this module", "what breaks if this changes", "impact analysis", "blast radius".'
argument-hint: 'Language + target symbol/file + optional scenario. Example: "TypeScript, target: src/payments/settle.ts::settleInvoice, scenario: if this function throws or returns stale data"'
user-invocable: true
---

# Layered Code Impact Analysis

## What This Skill Produces

- A layered explanation of the target code from function internals to system effects.
- A dependency and consumer map for the selected symbol/module.
- A breakage forecast that answers: "What might break if this breaks?"
- A confidence-rated report with validation steps and open unknowns.

## When to Use

- You need to quickly understand unfamiliar code.
- You are planning a refactor and want to avoid regressions.
- You are triaging an incident and need blast radius fast.
- You need to identify high-risk dependencies before changing behavior.

## Inputs To Request (If Missing)

- Target scope: symbol, file, module, or endpoint.
- Runtime context: environment, feature flags, integrations, data stores.
- Scenario to evaluate (optional): crash, timeout, wrong data, contract drift.
- Time depth: quick pass or deep pass.

If key inputs are missing, ask at most 2 clarifying questions, then proceed with explicit assumptions.

## Procedure

### 1) Define The Analysis Boundary

1. Identify the exact target:
   - Function/method name and file location.
   - Owning module/service.
2. State assumptions:
   - Runtime mode, config, and external services.
3. Pick depth:
   - Quick pass: core call chain only.
   - Deep pass: broader consumers plus data/state effects.

Quality gate:

- Target and assumptions are explicit before analysis starts.

### 2) Layer 1: Function-Level Behavior

1. Summarize what the function does in plain language.
2. Extract contract details:
   - Inputs, outputs, side effects, thrown errors.
3. Identify control-flow branches:
   - Guards, retries, fallback paths, early returns.
4. Note fragile points:
   - Null/empty handling, parsing, boundary math, temporal logic.

Quality gate:

- Function contract and risky branches are explicitly listed.

### 3) Layer 2: Immediate Dependencies

1. List direct dependencies:
   - Imported helpers, repositories, SDK clients, caches.
2. For each dependency, record:
   - Expected contract.
   - Failure modes (timeout, null, exception, stale cache, partial write).
3. Mark hidden coupling:
   - Shared mutable state, static singletons, implicit globals.

Quality gate:

- Every direct dependency has a contract and failure-mode note.

### 4) Layer 3: Data And State Flow

1. Trace important data from source to sink.
2. Identify state transitions:
   - In-memory state, persistence writes, message publish, cache updates.
3. Flag consistency risks:
   - Partial success, out-of-order writes, idempotency gaps.

Quality gate:

- Data/state transitions are mapped with consistency risk callouts.

### 5) Layer 4: Upstream Consumers

1. Find call sites and categorize consumers:
   - Internal callers, public endpoints, background jobs, scheduled tasks.
2. For each consumer, capture:
   - Dependency strength (hard/soft).
   - Visible symptom if target fails.
3. Rank affected consumers by business criticality:
   - Critical, high, medium, low.

Quality gate:

- Consumer map exists and includes criticality ranking.

### 6) Layer 5: System Blast Radius

1. Evaluate break scenarios:
   - Hard failure (throws/crashes).
   - Silent failure (wrong result, stale data).
   - Performance degradation (latency/resource spikes).
2. For each scenario, list:
   - First-order impact (directly broken paths).
   - Second-order impact (cascading failures, retries, queue buildup).
3. Propose mitigations:
   - Guards, retries, circuit breaker, fallback behavior, tests, observability.

Quality gate:

- Blast radius includes direct and cascade effects with mitigations.

### 7) Validate And Report

Produce a concise report with these sections:

1. Target and assumptions.
2. Layered findings (L1-L5).
3. Top 3 break risks.
4. Most likely user-visible symptoms.
5. Suggested protections and tests.
6. Confidence level (high/medium/low) and unknowns.

Quality gate:

- Report contains explicit unknowns and confidence rating.

## Decision Points (Branching)

### If Call Graph Is Dynamic Or Indirect

- Use best-effort discovery (naming conventions, routing, registration points).
- Mark uncertain links explicitly as "probable".
- Increase caution in blast-radius claims.

### If Tests Are Missing Or Weak

- Prioritize conservative assumptions.
- Suggest characterization tests before refactor.
- Lower confidence rating.

### If Multiple Failure Modes Are Plausible

- Separate by scenario and symptom.
- Rank by likelihood and severity.
- Recommend instrumentation to disambiguate in production.

### If Time Is Limited

- Deliver quick pass with clear "not analyzed yet" sections.
- Focus on highest-criticality consumers first.

## Completion Checks

Before finishing, confirm all are true:

- Target scope and assumptions are explicit.
- Function contract and risky branches are documented.
- Direct dependencies and failure modes are listed.
- Data/state flow and consistency risks are described.
- Upstream consumer map includes criticality.
- Blast radius covers direct and cascade impacts.
- Mitigations and test recommendations are actionable.
- Confidence and unknowns are explicitly stated.

## Example Prompts

- "Use layered-code-impact-analysis on TaskService.update in demo-codebase/app/services/task_service.py and tell me what breaks if validation starts rejecting null titles."
- "Run a quick layered analysis on this endpoint handler and focus on user-visible failures."
- "Do a deep blast-radius analysis for this repository method before I change its return type."
