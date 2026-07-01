# Module 1 — Foundations and Standards

**Morning session — AI-Assisted Development for Laravel Teams**

## Overview

This is the opening session. It establishes shared vocabulary, a working mental model of how LLMs behave, the non-negotiable distinction between public and enterprise AI, and the practical skills to prompt deliberately. It closes with a section on treating context as a team asset rather than a per-prompt afterthought.

This session replaces and merges the former Module 1 (Introduction to GenAI) and Module 2 (Core Prompt Engineering), which were appropriate for a generic course but split content that belongs together for this audience.

## Learning objectives

By the end of this session, participants will be able to:

- Use shared vocabulary to discuss AI-assisted development (LLM, prompt, hallucination, grounding, context window)
- Explain how LLMs are trained and why this produces hallucinations, bias, and knowledge cut-offs
- Make principled decisions about what to send to public vs. enterprise AI tools
- Write prompts that are clear, contextual, and constrained using the 3Cs framework
- Apply zero-shot, few-shot, and chain-of-thought prompting appropriately
- Iterate on prompts by reading output as a diagnosis
- Treat context as a team-level concern by encoding conventions in context files

## Suggested running time

90 minutes (instruction, demos, discussion)

## Session structure

| Section | Time |
|---|---|
| Shared vocabulary | 10 min |
| How LLMs work; public vs. enterprise | 20 min |
| Hallucination, bias, cut-offs, trust but verify | 10 min |
| The 3Cs: clarity, context, constraints | 20 min |
| Zero-shot, few-shot, chain-of-thought, iteration | 15 min |
| Context as code | 10 min |
| Summary and bridge | 5 min |

## Demos

- Same prompt in two environments (public vs. enterprise) — data handling behaviour
- Hallucination check: ask the model something version-specific (e.g. a Laravel 12 API) and show confident wrong output
- 3Cs live build: start with a vague prompt, add each C in turn, compare output at each step
- Context file demo: show how `.github/copilot-instructions.md` changes Copilot behaviour in VS Code

## Exercises

- **Classify**: given five scenarios, decide public AI / enterprise only / no AI — and justify
- **3Cs rewrite**: take a weak prompt from a provided set; rewrite it with clarity, context, and constraints; run both and compare
- **Context file**: draft a 5–10 point context file for your team; share one item in the group

## Files

- `presenterm_slides.md` — Presenterm-compatible slide deck
- `TEACHING_NOTES.md` — Facilitator notes with timing, demos, and common questions
- `exercises/` — Delegate-facing exercise instructions
- `demos/` — Facilitator demo notes and sample prompts
- `training-loop.png` — Diagram used in the LLM training slide
- `ollama.http` — HTTP prompts for live demo comparisons
