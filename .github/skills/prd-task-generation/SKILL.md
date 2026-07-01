---
name: prd-task-generation
description: 'Create focused PRDs for small features that generate AI-trackable task lists. Use when planning larger work and need to break it into checkpoints that keep AI focused and organized. Triggers: "create a PRD", "write a PRD", "plan this feature", "task list for", "break down feature", "scope this work".'
argument-hint: 'Feature goal (e.g., "Add user authentication with OAuth2"), scope (e.g., "small 1-3 day feature"), constraints or blockers (e.g., "must use existing JWT library").'
user-invocable: true
---

# PRD-Driven Task List Generation

## What This Skill Produces

- A structured PRD document (markdown) containing:
  - **Goal**: one clear sentence of what users/systems gain.
  - **Scope**: what's in/out (prevents scope creep).
  - **Acceptance Criteria**: testable "done" conditions.
  - **Technical Constraints**: dependencies, libraries, architecture patterns.
  - **Task Breakdown**: 3–8 granular subtasks with clear ownership/outputs.
  - **Test Strategy**: unit/integration/manual testing approach.
  - **Risks & Mitigations**: known blockers and fallback plans.
- A markdown task file with an organized checklist the AI can track via `manage_todo_list`.
- A focused, repeatable workflow: reduces ambiguity and keeps AI from drifting mid-feature.

## When to Use

- Building a feature that requires multiple steps or collaborations.
- Need to pause work and resume later with clear context.
- Working with Copilot on features that span multiple files/modules.
- Preventing scope creep and ensuring clear acceptance.

**Not ideal for:** Single-file, immediate tasks (<30 min) or emergency hotfixes—use a simple inline comment instead.

## Inputs You Should Provide (Best Results)

- **Feature Goal**: one or two sentences describing the end user/system benefit.
- **Scope Boundaries**: what's included and explicitly NOT included (prevent scope creep).
- **Known Constraints**: existing tech stack, libraries, design patterns, team standards.
- **Acceptance Success Metric**: how you'll know it's done (performance, coverage, user feedback, etc.).

If incomplete, ask **1–2 clarifying questions**, then proceed with reasonable assumptions.

---

## Procedure

### Phase 1: PRD Drafting (15–30 min)

#### 1A) Clarify the Feature Goal

1. Start with a one-sentence goal: "Users can [action] so they [benefit]."
2. Example: "Users can mark tasks as priority so they focus on urgent work."
3. Check: Is this a feature, a bug fix, or a refactor? (This skill focuses on features; bugs & refactors have different task structures.)

#### 1B) Define Scope Boundaries

Create an "In Scope" / "Out of Scope" checklist to prevent mid-project scope creep.

**In Scope:**

- Core use cases (2–3 main scenarios).
- Required integrations (existing APIs, databases, services).
- Minimum UI/UX polish.

**Out of Scope:**

- Advanced/nice-to-have features (log them for future work).
- Specific optimizations not on the critical path.
- Full analytics/instrumentation (stub it).

#### 1C) List Technical Constraints

- **Tech Stack**: language, framework, database, deployment target.
- **Design Patterns**: architecture style (layered, microservice, etc.) or naming conventions.
- **Existing Libraries**: what's already available (don't reinvent).
- **Performance / Security Baseline**: what's acceptable (e.g., "sub-100ms latency", "OWASP Top 10 compliance").
- **Backwards Compatibility**: any APIs or data formats that must stay stable?

#### 1D) Define Acceptance Criteria (INVEST-style)

Write 3–6 testable criteria. Each should be:

- **I**ndependent (not depend on others being done first).
- **N**egotiable (not a detailed spec, but clear enough).
- **V**aluable (contributes to the user/system benefit).
- **E**stimable (the team can roughly size the work).
- **S**mall (fits in a 1–3 day feature scope).
- **T**estable (you can verify it's done).

Example for "priority marking":

- [ ] User can click a task to toggle priority flag (High/Medium/Low/None).
- [ ] Priority state persists in the database.
- [ ] Task list re-sorts when priority changes (High tasks float to top).
- [ ] API returns priority in the task response.
- [ ] UI shows visual indicator (color, badge) for priority level.

#### 1E) Identify Test Strategy

Outline how you'll validate:

- **Unit Tests**: logic that doesn't depend on external services (e.g., priority comparison function).
- **Integration Tests**: database + API interactions (e.g., saving priority to DB and retrieving).
- **Manual/E2E**: user-facing flows (e.g., user clicks priority button, sees it stick).
- **Regression**: list any existing tests that might be affected.

### Phase 2: Break Into Tasks (10–20 min)

#### 2A) Identify Task Layers

Group work into logical layers (3–8 tasks):

1. **Data Model & Schema** (setup, no UI)
   - Add `priority` field to task entity.
   - Create/run migration if DB-backed.
   - Add default values.

2. **Repository / Persistence Layer**
   - Implement `UpdatePriority(taskId, priority)` method.
   - Add query method: `GetTasksByOwnerSorted(ownerId, sortBy: priority)`.

3. **Service / Business Logic**
   - Add validation (is priority enum value valid?).
   - Ensure `UpdateAsync` handles priority changes correctly.
   - Add any transactional safety (concurrency, rollback).

4. **API Contract / Controller**
   - Add `priority` field to `UpdateTaskRequest` DTO.
   - Add `priority` field to `TaskResponse` DTO.
   - Expose PATCH/PUT endpoint (or extend existing one).

5. **UI / Frontend**
   - Render priority dropdown or buttons on task card.
   - Implement click handler and API call.
   - Show loading/error state.

6. **Testing (across layers)**
   - Unit tests for priority enum & validation.
   - Integration tests for repository + service.
   - E2E/manual test of full flow.

7. **Documentation & Cleanup**
   - Update API docs / OpenAPI spec.
   - Add code comments where logic is non-obvious.
   - Remove debug logs or dead code.

8. **Deployment Prep** (if needed)
   - Verify migration strategy (does it need a rollback plan?).
   - Check backwards compatibility (old clients still work?).
   - Plan feature flag rollout (gradual enablement vs. immediate).

#### 2B) Order Tasks by Dependency

- Start with foundational tasks (data model, schema) first.
- Then build upward (persistence → service → API → UI).
- Save testing & documentation for after the core flow is working.

**Red Flag:** If one task is blocked by more than two others, consider splitting it further.

#### 2C) Size Each Task

Estimate effort loosely (in hours or t-shirt size: XS / S / M):

- **XS** (~30 min–1 hour): trivial, well-understood, low risk.
- **S** (~1–2 hours): straightforward, clear success criteria.
- **M** (~2–4 hours): some unknowns or complexity; may need a spike/spike test first.

If a task is larger than M (>4 hours), break it further or flag as a risk.

---

### Phase 3: Document & Activate (5–10 min)

#### 3A) Create the PRD Markdown File

Save a file like `PRD-task-priority.md` in the project root or docs folder:

```markdown
# PRD: Task Priority Sorting

## Goal

Users can mark tasks as priority (High/Medium/Low) so they can focus on urgent work first.

## Scope

### In Scope

- Ability to set priority on any task (dropdown: None / Low / Medium / High).
- Task list re-sorts automatically by priority (High first).
- Priority persists in database.
- API returns priority in task responses.
- Simple UI indicator (color badge).

### Out of Scope

- Advanced filtering (e.g., "show only High tasks").
- Analytics on priority patterns.
- Mobile app support (web only for this iteration).
- Bulk edit multiple tasks.

## Acceptance Criteria

- [ ] User can click a task to open priority selector (None / Low / Med / High).
- [ ] Selecting a priority persists to database within 2 seconds.
- [ ] Task list re-orders: High → Med → Low → None (descending).
- [ ] API GET /tasks/{id} returns priority field.
- [ ] API PATCH /tasks/{id} accepts and validates priority.
- [ ] UI shows a colored badge (Red=High, Orange=Med, Green=Low, Gray=None).
- [ ] Existing tests pass; new tests cover priority sorting logic.

## Technical Constraints

- **Stack**: .NET 9, EF Core, React (existing).
- **DB**: PostgreSQL; support migrations.
- **Enums**: Use existing Priority enum (Low, Medium, High).
- **Performance**: Priority sort must complete <100ms for 10k tasks.
- **Security**: No privilege escalation; users can only edit their own tasks.
- **Backwards Compat**: Old API clients ignore priority field gracefully.

## Task Breakdown

### Task 1: Data Model & Schema (Effort: XS ~1 hour)

- [ ] Add `Priority` property to `TaskItem` entity (already exists, just verify).
- [ ] Verify EF Core migration exists for Priority field.
- [ ] Set default: `Priority = Priority.Medium`.
- [ ] Run migrations locally; verify schema.

### Task 2: Repository Layer (Effort: S ~2 hours)

- [ ] Add `GetTasksByOwnerAsync(ownerId, sortBy: "priority")` to `ITaskRepository`.
- [ ] Implement sort logic: High → Med → Low → None.
- [ ] Test with in-memory repo: 5 tasks with mixed priorities sort correctly.

### Task 3: Service Layer (Effort: S ~2 hours)

- [ ] Extend `UpdateAsync` to accept priority in `UpdateTaskRequest`.
- [ ] Validate priority enum value; throw if invalid.
- [ ] Call repository update; return updated task.
- [ ] Write unit tests for priority validation & update flow.

### Task 4: API & DTOs (Effort: XS ~1 hour)

- [ ] Add `Priority` property to `UpdateTaskRequest` DTO.
- [ ] Add `Priority` property to `TaskResponse` DTO.
- [ ] Ensure controller passes priority through to service.

### Task 5: UI Component (Effort: M ~3 hours)

- [ ] Create `<PrioritySelector>` component (dropdown or button group).
- [ ] Render on task card; display current priority as colored badge.
- [ ] Call API `PATCH /tasks/{id}` with new priority.
- [ ] Show loading state during update; handle errors gracefully.
- [ ] Re-fetch task list after update to confirm re-sort.

### Task 6: Integration & E2E Tests (Effort: M ~2–3 hours)

- [ ] Write integration test: update priority → verify repo saves it.
- [ ] Write integration test: sort query returns tasks by priority order.
- [ ] Manual test: click priority button, see list re-order.
- [ ] Verify old clients (without priority awareness) still work.

### Task 7: Documentation (Effort: XS ~30 min)

- [ ] Update API docs (OpenAPI / Swagger) with priority field.
- [ ] Add inline code comments where priority logic is non-obvious.
- [ ] Ensure migration is documented for deployment team.

## Test Strategy

- **Unit**: Priority validation, enum parsing, sort comparator function.
- **Integration**: Repository + Service + API PATCH flow; database persistence.
- **E2E / Manual**: User clicks priority dropdown, sees task re-sort, then refresh and verify it stuck.
- **Regression**: Ensure existing CreateAsync, GetByOwner, Delete tests still pass.

## Risks & Mitigations

| Risk                                       | Impact              | Mitigation                                                                                 |
| ------------------------------------------ | ------------------- | ------------------------------------------------------------------------------------------ |
| Database migration fails in production     | Data loss, downtime | Test migration locally; have rollback plan (reverse migration script).                     |
| Old clients don't handle priority field    | API breaking change | Make priority optional in response; default to None for old requests.                      |
| UI re-sort is slow (>100ms)                | Poor UX             | Profile with 10k tasks; use indexed queries; consider client-side sorting for small lists. |
| Concurrent priority updates race condition | Lost updates        | Add optimistic locking (ETag/version) or test with concurrent requests.                    |

## Definition of Done

- [ ] All acceptance criteria met.
- [ ] Unit tests written; coverage ≥80% for priority logic.
- [ ] Integration tests pass (repo, service, API layers).
- [ ] Manual E2E test completed; priority sticks after refresh.
- [ ] Existing test suite passes (no regressions).
- [ ] API docs updated.
- [ ] Migration tested locally and ready for deployment.
- [ ] Code review approved.

## Next Steps (Future)

- Priority-based filtering and search.
- Bulk edit priority for multiple tasks.
- Mobile app support.
- Priority change history / audit log.
```

#### 3B) Create the Task Tracking File

Save `TASKS-task-priority.md` in the same location:

```markdown
# Task Tracking: Task Priority Sorting

**Start Date:** [TODAY]  
**Target Completion:** [DATE +1-3 days]

## Phase 1: Data & Persistence ⬜

- [ ] Data Model & Schema (1 hr)
- [ ] Repository Layer (2 hr)

## Phase 2: Service & API ⬜

- [ ] Service Layer (2 hr)
- [ ] API & DTOs (1 hr)

## Phase 3: UI & Testing ⬜

- [ ] UI Component (3 hr)
- [ ] Integration & E2E Tests (2–3 hr)

## Phase 4: Polish & Deploy ⬜

- [ ] Documentation (30 min)
- [ ] Final review & merge

**Total Effort:** ~16–18 hours (fits in 2–3 day sprint for small team)

## Notes

- Task 1 (Data Model) may already be done; verify first.
- Task 5 (UI) is the riskiest; spike if needed.
- If database migration is complex, pull Task 1 forward and test early.
```

#### 3C) Activate Task Tracking in Copilot

When you start the work, use the conversation to invoke `manage_todo_list`:

```
I'll now create a task list from this PRD. Here's the breakdown:

[Copilot uses manage_todo_list to activate the tracking]
```

---

## Decision Points (Branching)

### If Feature Scope Is Unclear

1. List all possible features (10 min brainstorm).
2. Group by priority: must-have (MVP) vs. nice-to-have (Phase 2).
3. The MVP becomes "In Scope"; the rest goes to "Out of Scope / Future".

**Example:** "Add priority" (MVP) vs. "Advanced filtering on priority" (Future).

### If Technical Design Is Uncertain

1. Identify the unknown (e.g., "Can we reuse Priority enum or need a new one?").
2. Run a **spike**: 15–30 min exploration or prototype.
3. Document the decision in "Technical Constraints" section.
4. Proceed with confidence.

### If a Task Is Stuck or Blocked

1. Pause that task.
2. Identify the blocker (missing info, external dependency, etc.).
3. Log it in the PRD's Risks section with a mitigation.
4. Move to the next unblocked task.

### If Scope Expands Mid-Feature

1. **Stop and ask:** Is this still a 1–3 day feature, or did it grow?
2. If grown → create a **new PRD** for the expanded feature or move extras to Phase 2.
3. **Do not** silently bloat the current task list.

---

## Completion Checks

Before considering the feature **done**:

- [ ] All acceptance criteria checked off (or explicitly deprioritized with user sign-off).
- [ ] Every task in the breakdown is complete (no "almost done" tasks lingering).
- [ ] Tests pass: unit, integration, and manual E2E.
- [ ] Existing tests still pass (no regressions).
- [ ] Code is reviewed and approved.
- [ ] API / docs updated if applicable.
- [ ] Deployment plan documented (migration, feature flags, rollback).
- [ ] User can demonstrate the feature working end-to-end.

---

## Output Format (How to Report Work)

When done, provide a summary:

```
## Feature Complete: Task Priority Sorting ✅

**PRD:** [link to PRD-task-priority.md]

**Completion Date:** [DATE]

**Effort Breakdown:**
- Data Model & Schema: ✅ (took 45 min, faster than estimated)
- Repository Layer: ✅ (2 hr)
- Service Layer: ✅ (1.5 hr, refactored shared logic)
- API & DTOs: ✅ (1 hr)
- UI Component: ✅ (3.5 hr, added debounce to avoid flicker)
- Integration & E2E Tests: ✅ (2 hr)
- Documentation: ✅ (30 min)

**Total: 14.5 hours (under estimate)**

**Key Decisions:**
- Reused existing Priority enum (didn't need a new one).
- Added optimistic locking to prevent race conditions.
- UI sorts client-side for snappiness; backend query also sorts for consistency.

**Testing:**
- 6 new unit tests for priority logic.
- 3 integration tests covering full flow.
- Manual E2E: confirmed priority sticks across refresh.
- All existing tests pass (regression-free).

**Deployment:**
- Migration: `202401_AddPriority` (idempotent, safe to rerun).
- Feature flag: none (ship immediately).
- Rollback: reverse migration script tested locally.

**Next Steps:**
- Phase 2: Advanced filtering (separate PRD).
- Post-launch monitoring: check for race condition reports.
```

---

## Notes for Agents (Discipline Rules)

1. **Do not expand scope mid-task.** If a user asks for something new mid-implementation, create a **new PRD** or add it to "Out of Scope / Future Work".

2. **Keep tasks to 4 hours max.** If a task is larger, break it further or flag it as high-risk.

3. **Write the PRD _before_ coding.** (Even if it's a 10-min rough draft, it prevents drift.)

4. **Prioritize acceptance criteria over "nice implementation."** If it's done and tested, ship it; optimization is a future task.

5. **Track progress using `manage_todo_list`** during work; update frequently. This keeps the AI and user synchronized.

6. **Flag risks early.** If a task has dependencies or unknowns, call them out in the Risks section, then proceed with the mitigation.

7. **Never skip the Definition of Done checklist.** A feature isn't complete until all boxes are checked.

---

## Suggested Next Skills

Once you've mastered PRD-driven development, consider pairing with:

- **Strict TDD:** Use for high-coverage feature tasks; combine TDD's discipline with PRD's structure.
- **Code Review Checklist:** Create a parallel skill for reviewing PRD-delivered code.
- **Retrospective Prompt:** Track which estimates were off and why; improve estimation over time.
