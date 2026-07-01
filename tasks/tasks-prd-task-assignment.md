## Relevant Files

- `demo-codebase/app/Models/TaskItem.php` - Add nullable assignee field and keep task mapping compatibility with current in-memory model shape.
- `demo-codebase/app/Repositories/TaskRepositoryInterface.php` - Ensure repository contract supports assignment-aware updates and (if needed) assignee-focused queries.
- `demo-codebase/app/Repositories/InMemoryTaskRepository.php` - Persist assignee changes and extend JSON serialization/deserialization for assignee data.
- `demo-codebase/app/Services/TaskService.php` - Implement assignment/reassignment logic, preserve assignment on unrelated edits, and trigger audit/notification flows.
- `demo-codebase/app/Http/Requests/UpdateTaskRequest.php` - Validate assignment input and surface invalid assignee errors.
- `demo-codebase/app/Http/Resources/TaskResource.php` - Expose assignee metadata for detail/list responses.
- `demo-codebase/app/Http/Controllers/Api/TaskController.php` - Keep response behavior correct for invalid assignee, missing task, and authenticated assignment updates.
- `demo-codebase/app/Models/User.php` - Source of valid users for assignment and notification targets.
- `demo-codebase/routes/web.php` - Add authenticated task edit/display routes if the first version introduces Blade task pages.
- `demo-codebase/resources/views/tasks/edit.blade.php` - Task edit UI with clear "Assigned to" control and explicit unassigned state.
- `demo-codebase/resources/views/tasks/show.blade.php` - Task detail UI showing current assignee.
- `demo-codebase/resources/views/tasks/index.blade.php` - Task list UI showing assignee where ownership metadata is expected.
- `demo-codebase/database/migrations/2026_07_01_000001_add_assignee_id_to_tasks_table.php` - Add nullable single-assignee foreign key if moving from in-memory to DB-backed tasks.
- `demo-codebase/database/migrations/2026_07_01_000002_create_task_assignment_audit_logs_table.php` - Create audit table for assignment/reassignment events.
- `demo-codebase/app/Models/TaskAssignmentAuditLog.php` - Represent assignment audit records.
- `demo-codebase/app/Notifications/TaskAssignedNotification.php` - Notify newly assigned users on assignment/reassignment.
- `demo-codebase/tests/Unit/TaskServiceTest.php` - Unit coverage for assignment logic, reassignment behavior, and unchanged-assignment updates.
- `demo-codebase/tests/Feature/TaskAssignmentFeatureTest.php` - Feature/API/UI tests for auth gating, validation, visibility, audit, and notifications.

### Notes

- Unit tests should typically be placed alongside the code files they are testing, or under `tests/Unit` and `tests/Feature` following existing Laravel project conventions.
- Use `php artisan test` to run all tests, or `php artisan test --filter=TaskServiceTest` for focused task assignment unit checks.
- The current demo codebase is API-first with in-memory task persistence and no existing task Blade pages; task UI files above are expected additions for this PRD.
- The current task model uses `owner_id`; this feature introduces a separate single `assignee` concept and should not silently repurpose owner semantics.

## Tasks

- [ ] 1.0 Add assignee support to the task domain model and persistence layer
  - [x] 1.1 Add a nullable single-assignee field to the task model (`assignee_id` or equivalent) while preserving existing owner fields.
  - [x] 1.2 Update persistence mapping/serialization so tasks can store and load unassigned and assigned states consistently.
  - [x] 1.3 Ensure task response/resource payloads include assignee data needed by task detail/list views.
  - [ ] 1.4 Confirm assignment state survives normal task edits and service round-trips.

- [ ] 2.0 Add authenticated assignment/reassignment handling to task update flows
  - [ ] 2.1 Extend task update validation to accept optional assignee input and reject invalid user IDs with clear errors.
  - [ ] 2.2 Enforce that only authenticated users can perform assignment/reassignment actions.
  - [ ] 2.3 Implement service-level assignment/reassignment behavior, including no-op when assignment field is omitted.
  - [ ] 2.4 Ensure update behavior returns not-found for missing tasks and does not apply assignment changes in that case.

- [ ] 3.0 Build task edit/detail/list assignment UX (including user selection and unassigned state)
  - [ ] 3.1 Add an "Assigned to" control on the task edit screen that lists valid users and clearly indicates unassigned.
  - [ ] 3.2 Pre-populate edit UI with current assignee to make reassignment explicit and understandable.
  - [ ] 3.3 Show assignee in task detail view with consistent metadata styling.
  - [ ] 3.4 Show assignee in task list screens intended to communicate ownership.
  - [ ] 3.5 Define and implement explicit behavior for clearing assignee (if enabled for v1) and reflect it in UI copy/validation.

- [ ] 4.0 Implement assignment audit trail capture for assignment and reassignment events
  - [ ] 4.1 Create audit log structure for assignment events including task ID, previous assignee, new assignee, actor, and timestamp.
  - [ ] 4.2 Record an audit event whenever assignment is added or changed.
  - [ ] 4.3 Ensure audit entries are not duplicated for updates that do not change assignment.
  - [ ] 4.4 Align audit write path with existing logging/activity approach used by the project.

- [ ] 5.0 Send assignee notifications when assignment ownership changes
  - [ ] 5.1 Implement a notification for newly assigned users for both first assignment and reassignment.
  - [ ] 5.2 Trigger notifications only when assignee actually changes to a different valid user.
  - [ ] 5.3 Avoid notifying on unchanged assignment or failed update operations.
  - [ ] 5.4 Use existing Laravel notification infrastructure and configure delivery channel for this project.

- [ ] 6.0 Add automated test coverage for assignment rules, validation, authorization, auditing, and notifications
  - [ ] 6.1 Add unit tests for assignment creation, reassignment, omitted assignment preservation, and invalid assignee handling.
  - [ ] 6.2 Add feature tests verifying unauthenticated users are blocked from assignment actions.
  - [ ] 6.3 Add feature tests for not-found task assignment attempts and expected response behavior.
  - [ ] 6.4 Add tests that verify assignee visibility in task detail and relevant task list responses/views.
  - [ ] 6.5 Add tests asserting audit records are written with correct previous/new assignee and actor metadata.
  - [ ] 6.6 Add notification tests (faked notifications) verifying only newly assigned users are notified on assignment changes.
