# Module 1: Introduction to GenAI for Developers

## Learning objectives

- Explain the current LLM landscape and how to choose the right model/tool for the job (GPT-4, Claude, etc.).
- Articulate critical distinctions between public AI and enterprise instances (data privacy and security).
- Apply context-aware best practices for using GitHub Copilot for Business with internal datasets vs. generic coding tools.
- Describe AI capabilities and limitations: hallucinations, knowledge cut-offs, and bias.
- Recognise when not to trust AI output and how to verify it.

## Suggested talking points

- The LLM landscape: model families, providers, and “which tool for which job.”
- Data privacy & security: public vs. enterprise AI; what stays in-house.
- GitHub Copilot for Business in context: safe use with internal data; what to avoid with generic tools.
- Capabilities & limitations: hallucinations, cut-off dates, bias; “trust but verify.”
- When to rely on AI vs. when to double-check or avoid.

## Suggested demos

- Quick comparison: same prompt in two environments (e.g. public vs. enterprise) to show context/behaviour differences.
- Short “hallucination check”: ask a model something outside its knowledge or with a wrong premise and show how to spot and correct.
- nullable reference types: side-by-side model comparison (e.g. GPT-4 vs. Claude) on one coding question to illustrate “right tool for the job.”

## Suggested exercises

- **Audit:** List 2–3 tasks you do today that could use AI and 2–3 where you would not use it; share in pairs.
- **Checklist:** Draft a 3–5 point “safe use” checklist for your team (data, verification, when to escalate).
- **Scenario:** Given a scenario (e.g. “explain this internal API”), decide: public AI OK or enterprise-only, and why.

## Suggested running time

45–60 minutes

---

## Module structure

- **`TEACHING_NOTES.md`** — Detailed teaching notes following the teaching style guide (problem-first, progressive building, time allocations, common questions, teaching tips).
- **`slides.md`** — Slide content in reveal.js format (use `---` as slide separator). Updated with problem-first approach and conceptual bridges.
- **`index.html`** — Present the deck in a browser. Loads `slides.md` via the reveal.js markdown plugin.  
  **To present:** Run a local server from this directory (e.g. `npx serve .` or `python3 -m http.server 8000`) then open `http://localhost:8000` (or the port shown). Opening `index.html` via `file://` may block loading `slides.md` in some browsers.
- **`demos/`** — Facilitator notes and sample prompts for each demo (see `demos/README.md`). Updated with problem-first approach, progressive building, and time allocations.
- **`exercises/`** — Delegate-facing exercise instructions (see `exercises/README.md`). Updated with progressive difficulty, hints, collapsible solutions, and real-world scenarios.

---

## Teaching style applied

This module follows the teaching style principles:

- ✅ **Problem-first learning**: Slides and demos start with pain points/confusion before solutions
- ✅ **Progressive building**: Simple → complex (landscape → privacy → limitations)
- ✅ **Real-world context**: Scenarios delegates will encounter (internal APIs, Laravel/PHP)
- ✅ **Guided discovery**: Exercises include hints and collapsible solutions
- ✅ **Conceptual bridges**: Explicit connections between sections and to Module 2
- ✅ **Time allocations**: Clear timing for each section in teaching notes
- ✅ **Common questions**: Anticipated confusion points addressed in teaching notes

**Note**: One slide ("Capabilities and limitations") may need manual update to add problem-first framing — see `TEACHING_NOTES.md` for the intended content.
