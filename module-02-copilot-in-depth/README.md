# Module 2 — Copilot in Depth

**Late morning session — AI-Assisted Development for Laravel Teams**

## Overview

This session goes inside GitHub Copilot: inline completion, Copilot Chat, the terminal, and PRD-driven development. It assumes the foundations from the morning session — the 3Cs, context as code, public vs. enterprise — and builds directly on them with the specific surfaces the team uses every day.

All examples are drawn from a Laravel/PHP codebase (routing, controllers, Eloquent, Pest testing).

## Learning objectives

By the end of this session, participants will be able to:

- Improve inline completion quality using signal techniques (method naming, comment-first, pattern-start)
- Use Copilot Chat slash commands (`/explain`, `/fix`, `/tests`, `/doc`) on real code
- Reference specific files in Chat using `#file:` syntax
- Use Copilot in the integrated terminal for shell tasks and Artisan commands
- Write a PRD-style spec in markdown format
- Use a spec to generate a consistent multi-layer feature (Form Request, service, controller, tests) in sequence

## Suggested running time

90 minutes including exercises

## Session structure

| Section | Time |
|---|---|
| Inline completion — signal and acceptance | 20 min |
| Copilot Chat — slash commands and file referencing | 20 min |
| Copilot in the terminal | 10 min |
| Copilot in a Laravel codebase (routing, Eloquent, testing) | 15 min |
| PRD-driven development | 20 min |
| Surface selection and summary | 5 min |

## Demos

- Inline: blank method name vs. intent-driven name — show the difference in suggestion quality
- Inline: `Tab` vs. `Ctrl+→` — demonstrate word-by-word acceptance catching a subtle bug
- Chat: `/explain`, `/fix`, `/tests` on `TaskService.php` in sequence
- Chat: `#file:` referencing to generate an implementation from an interface
- Terminal: Copilot suggesting an Artisan command from a plain-English description
- PRD: generate UpdateTaskPriority feature in four layers live

## Exercises

- **Inline signal**: rewrite three vague method signatures to be intent-driven; observe the difference in suggestions
- **Chat slash commands**: run `/explain`, `/fix`, and `/tests` on a provided service class; compare to what you'd have written manually
- **PRD**: write a spec for a small feature in the demo codebase and generate the first two layers

## Files

- `presenterm_slides.md` — Presenterm-compatible slide deck
- `TEACHING_NOTES.md` — Facilitator notes with demo sequences
- `exercises/` — Delegate-facing exercise instructions
