# AI-Assisted Development for Laravel Teams

**A one-day instructor-led course for the Rabbies development team, delivered remotely via Microsoft Teams.**

Prepared by Kevin Cunningham (via Indicia Training) — May 2026.

---

## What this course is

This course is for a development team that is already using AI tooling day to day and wants to move from individual, ad-hoc approaches to a shared, principled standard. It is not an introduction to AI. It is a course in using it well — consistently, safely, and across the full development lifecycle.

GitHub Copilot for Business is the primary tool in scope, situated within a Laravel/PHP codebase. The course also looks ahead to where things are heading: agents, Model Context Protocol, and multi-agent workflows.

All examples are drawn from Laravel and PHP throughout.

---

## Who it is for

Developers working in Laravel/PHP who already have GitHub Copilot available and are beginning to explore what more advanced patterns — agents, MCP — might look like. No prior prompt engineering knowledge is assumed. The course meets the team where they are: technically capable and curious, but without a unified process.

---

## Learning outcomes

By the end of the engagement, participants will be able to:

- Apply a consistent, principled approach to AI-assisted development across the full SDLC
- Use GitHub Copilot effectively in a Laravel/PHP context, beyond basic autocompletion
- Write prompts and structure context deliberately — treating context as a first-class concern
- Identify where AI assistance adds genuine value and where human judgement is irreplaceable
- Understand the security implications of AI tooling and apply appropriate guardrails
- Articulate a shared team standard for AI use, reducing ad-hoc variation
- Recognise what is coming next — agents, MCP, multi-agent workflows — and how it connects to their current work

---

## Course structure

### Day 1 — Core Programme

A full day delivered via Teams, with a mix of instruction, demonstration, and hands-on exercises. Sessions move from foundations to standards to a forward-looking close.

#### Morning — Foundations and Standards

Shared vocabulary; how LLMs actually work (enough to reason about behaviour); prompt engineering principles; context as code — structuring prompts and project context deliberately; garbage in / garbage out in practice.

#### Late Morning — Copilot in Depth

Beyond tab completion — inline chat, slash commands, Copilot in the terminal. Effective use within a Laravel codebase: routing, controllers, Eloquent, and testing. Managing suggestions critically rather than accepting passively.

#### Afternoon — SDLC Integration

Applying AI across the full development lifecycle: requirements and planning, code generation, refactoring, code review, documentation, and test writing. Establishing team conventions. Security guardrails and what not to send to an AI model.

#### Late Afternoon — The Art of the Possible

Introduction to agents and agentic workflows. Model Context Protocol (MCP) — what it is and why it matters. Multi-agent patterns. A glimpse of TDD with an agent harness. Where the Laravel ecosystem is heading with AI tooling.

---

### Follow-Up Session (approx. 4 weeks later)

A half-day session scheduled approximately four weeks after the core day, structured as a combination of retrospective and deeper dive:

- Review: what has the team adopted, what has worked, what has not?
- Common patterns and anti-patterns that have emerged
- Targeted Q&A based on real work done since the core day
- One deeper-dive topic chosen by the team (e.g. a specific Copilot feature, prompt patterns for the domain, or an expanded look at agents)

This session is deliberately adaptive. Its value comes from being anchored in what the team has actually experienced.

---

## Possible follow-on topics

Depending on how the team develops and what interests emerge, these areas are available as standalone sessions or a short programme:

| Topic | Description |
|---|---|
| Building an MCP Server | Design and build a custom MCP server to connect AI models to your own tools and data sources |
| Retrieval-Augmented Generation (RAG) | Add your own data to LLM responses — useful for customer-facing features, internal knowledge tools, or domain-specific code assistance |
| OWASP LLM Top 10 | A security-focused session covering prompt injection, data leakage, insecure output handling, and defensive design |
| Evaluations and Testing AI Features | How to test AI-powered features reliably — defining test outcomes, building an agent harness, and maintaining quality as models and prompts evolve |
| AI Product Integration Patterns | Patterns for embedding AI features into existing products — UX considerations, latency, fallback handling, and keeping humans in the loop |

---

## Repository structure

```
module-01-foundations-standards/   Morning — shared vocabulary, LLMs, 3Cs, context as code
module-02-copilot-in-depth/        Late morning — inline, Chat, terminal, PRD-driven
module-03-sdlc-integration/        Afternoon — full lifecycle, conventions, security guardrails
module-04-art-of-the-possible/     Late afternoon — agents, MCP, multi-agent, TDD harness
demo-codebase/                     Laravel project used for hands-on exercises
general_teaching/                  Shared teaching materials and style guide
```

Each module contains:

- `presenterm_slides.md` — Presenterm-compatible slide deck
- `README.md` — module overview, objectives, and timing
- `TEACHING_NOTES.md` — facilitator notes with demo sequences, common questions, and tips
- `exercises/` — delegate-facing exercise instructions
- `demos/` — facilitator demo notes and sample prompts (where applicable)

`demo-codebase/` contains a Laravel project used from Module 2 onwards. See `demo-codebase/TEACHING_NOTES.md` for setup and module mapping.

```bash
cd demo-codebase
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan serve
./vendor/bin/pest tests/Unit/TaskServiceTest.php
```

---

## Prerequisites for delegates

- VS Code with the GitHub Copilot extension installed (PhpStorm also works)
- GitHub Copilot for Business licence active
- PHP 8.3+ and Composer installed (Laravel Herd recommended on macOS)
- The provided `demo-codebase/` Laravel project, or your own Laravel project for exercises

---

## Delivery

All sessions are delivered remotely via Microsoft Teams. Instruction is practical throughout — examples are drawn from Laravel and PHP, not generic code snippets. Given the spectrum of opinions on the team about what AI can and cannot do, sessions are designed to be honest: the goal is calibrated confidence, not hype.

All materials — exercises, reference guides, prompt templates — are provided and remain with the team after the engagement.
