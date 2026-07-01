# Module 4 — The Art of the Possible

**Late afternoon session — AI-Assisted Development for Laravel Teams**

## Overview

The closing session of the day. It looks ahead: agents, Model Context Protocol, multi-agent patterns, TDD with an agent harness, and where the Laravel ecosystem is heading. The goal is not to turn delegates into agent builders today — it is to give them a calibrated picture of what is coming and how it connects to the standards and practices covered earlier in the day.

This session is deliberately forward-looking and conceptual. Demos are kept simple. The emphasis is on mental models and the key questions the team needs to answer as this technology matures.

## Learning objectives

By the end of this session, participants will be able to:

- Explain the difference between a prompt and an agent
- Describe what an agentic workflow looks like in a development context
- Explain what Model Context Protocol (MCP) is and why it matters for connecting AI to team tooling
- Recognise common multi-agent patterns (orchestrator, critic, specialist)
- Describe how TDD can be combined with an agent harness
- Articulate what changes — and what doesn't — as the team moves toward agentic development

## Suggested running time

60 minutes (instruction and discussion — no hands-on exercises)

## Session structure

| Section | Time |
|---|---|
| What is an agent? | 10 min |
| Agentic workflows — human role and failure modes | 10 min |
| Model Context Protocol (MCP) | 10 min |
| Multi-agent patterns | 10 min |
| TDD with an agent harness | 10 min |
| The Laravel ecosystem and what changes for the team | 10 min |

## Demos

- **Agent in action**: run a short agentic task live using Cursor, Cline, or OpenCode — ask it to add a simple endpoint following existing conventions; show the steps it takes
- **MCP demo**: if available, show a GitHub MCP server or filesystem MCP server in action — the model reading real data rather than pasted data
- **TDD harness**: show a failing Pest test being passed to an agent; observe what the agent does; review the result

If live tooling is unavailable or unreliable, walk through the demos conceptually using the slide examples. The mental model matters more than the tool.

## Discussion points

This session is as much discussion as instruction. Build in time for:

- "Which of these patterns would change how you work most?"
- "What would you want an MCP server to expose from your own infrastructure?"
- "What would need to be true about your test suite for TDD with an agent to be reliable?"

## Files

- `presenterm_slides.md` — Presenterm-compatible slide deck
- `TEACHING_NOTES.md` — Facilitator notes
- `exercises/` — Optional discussion exercises (no hands-on coding)
