# Module 3 — SDLC Integration

**Afternoon session — AI-Assisted Development for Laravel Teams**

## Overview

This session applies AI assistance across the full software development lifecycle — from requirements and planning through code review and documentation. It expands on the code generation techniques from earlier in the day to cover the full range of where AI adds value (and where it doesn't), and closes with establishing team conventions and security guardrails.

## Learning objectives

By the end of this session, participants will be able to:

- Use AI to draft requirements and convert rough ideas into structured specs
- Apply code generation incrementally and evaluate output before applying it
- Use the layered explanation approach for unfamiliar or legacy code
- Refactor safely with AI using a test-first sequence
- Use AI for a first-pass code review, knowing what it can and cannot catch
- Generate documentation with meaningful constraints (not just type restatements)
- Write explicit test scenarios and iterate on AI-generated Pest suites
- Articulate shared team conventions for AI-assisted development
- Identify which code is always written manually and which data is never sent to AI

## Suggested running time

90 minutes including exercises

## Session structure

| Section | Time |
|---|---|
| SDLC overview — where AI fits | 10 min |
| Requirements and planning | 10 min |
| Code generation (incremental, with evaluation checklist) | 20 min |
| Explanation — layered approach | 10 min |
| Refactoring — safety first | 10 min |
| Code review — AI as first pass | 10 min |
| Documentation | 5 min |
| Test writing — generate, run, refine | 10 min |
| Team conventions and security guardrails | 15 min |
| Summary | 5 min |

## Demos

- Requirements: turn a rough brief into a spec using AI; show what it adds and what you'd change
- Generation: generate a Book model without version context, then with it — compare the output
- Refactoring: generate tests for a method, run them, refactor, run them again
- Code review: run a targeted review prompt against a provided controller with known issues
- Security: demonstrate what a prompt with a redacted credential looks like — and why even the redacted version may be a problem

## Exercises

- **Generation**: from a two-sentence spec, generate a service incrementally (model → repository → service); use the evaluation checklist on each layer
- **Review**: take a provided Laravel controller with five known issues; write a review prompt; compare what AI catches vs. what a human reviewer would catch
- **Conventions**: as a group, draft the first version of your team's convention list; decide what goes in the context file

## Files

- `presenterm_slides.md` — Presenterm-compatible slide deck
- `TEACHING_NOTES.md` — Facilitator notes
- `exercises/` — Delegate-facing exercise instructions
- `demos/` — Facilitator demo notes
