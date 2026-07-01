# Task Management API — Copilot Instructions

This Laravel API manages tasks for project owners. Follow these conventions when generating code.

## Stack

- Laravel 13, PHP 8.3+
- Pest for tests (not PHPUnit class syntax)
- Constructor injection via the Laravel container — no facades in services
- In-memory repository for demos (no Eloquent in the service layer yet)

## Patterns

- API routes live in `routes/api.php` under the `/api` prefix
- Controllers are thin — validation in Form Requests, logic in services
- Services throw `InvalidArgumentException` for business rule violations
- JSON responses use `TaskResource` for task entities
- Error responses use `{ "error": "message" }` with appropriate HTTP status codes

## Naming

- Use `TaskItem` for the domain model, `TaskService` for business logic
- Form Requests: `StoreTaskRequest`, `UpdateTaskRequest`
- Priority values: `Low`, `Medium`, `High` (case-sensitive strings)
- Status values: `Todo`, `InProgress`, `Done`

## Testing

- Use Pest with Mockery for repository mocking
- Test file location: `tests/Unit/TaskServiceTest.php`
- Follow existing `describe` / `it` block structure
