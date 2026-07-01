# Module 1 — Exercises

**For delegates.** These exercises run during the Module 1 session. Your facilitator will manage timing and breakout rooms.

---

## Objective

By the end of these exercises you will be able to:

- Identify where in your daily work AI assistance is appropriate — and where it isn't
- Apply a consistent decision rule to ambiguous data privacy scenarios
- Articulate a defensible position on a genuinely contested case

---

## Scenario

You're a PHP developer working on a Laravel application with an internal REST API. Your team is exploring how to use AI tools to improve productivity, but you need to establish clear guidelines about **where**, **when**, and **how** to use AI safely.

---

## Exercise 1: Audit — where would you use AI, and where not?

**Individual first (5 minutes), then breakout (5 minutes)**

**Your task:**

- List **2–3 tasks** from your actual daily work where AI assistance makes sense
- List **2–3 tasks** where you would **not** use AI, or would use it with extra care
- Format as a short table

**Prompts to help you think:**

- What makes a task suitable for AI — is the information generic or proprietary? Is it testable?
- What makes a task risky — security, compliance, internal systems?
- Think about: code generation, debugging, documentation, testing (PHPUnit/Pest), configuration
- Think about your tooling: PhpStorm, VS Code with Intelephense, Laravel Herd, Composer — where does AI fit in your daily workflow?

**In your breakout room:**

Share your tables. Find one task where you and your partner classified it differently. Try to agree on a single rule that would resolve the disagreement — not a compromise, but the rule that is actually more correct. **One person feeds back to the main room: what was the disagreement, and what rule did you land on?**

---

## Exercise 2: The disputed request

**Breakout — 10 minutes**

**Context:**

A senior developer on your team has sent this message in Slack:

> "I've been using ChatGPT to help me write our onboarding docs. It's much faster. I don't paste any code — just describe the system in plain English. Is there any reason I can't do this?"

**Your task:**

Agree a reply as a pair — 3–5 sentences. Your reply should:

- Give a clear recommendation (yes, no, or yes with conditions)
- State the specific risk that justifies your recommendation — or the specific reason there isn't one
- Be something you could actually send to a colleague, not a policy recitation

**Back in the main room:** Each breakout room reads their reply. The facilitator will note where recommendations differ — focus on whether the disagreement is about what counts as proprietary, or what level of risk is acceptable.

---

## Exercise 3: Scenario — public AI or enterprise-only?

**Individual (3 minutes), then whole group**

**Your task:**

For the scenario below, decide whether using **public AI** is acceptable, or whether this requires **enterprise-only** (or no AI at all). Write **one sentence** explaining why.

**Scenario:**
*You're a PHP/Laravel developer. A colleague wants to ask an AI to explain how your team's internal REST API works. They paste the API's OpenAPI spec — endpoint paths and request/response schemas, but no real data — into the chat.*

**Your answer:**

- [ ] Public AI is acceptable because…
- [ ] Enterprise-only (or no AI) because…

**Type your answer (public / enterprise / no AI) in chat.** The facilitator will call on someone from each camp to give their one-sentence reason. If you agreed with the majority immediately, be ready to answer: what specific fact would change your mind?

---

## Extensions

If you finish early or want to go deeper:

1. **Find your organisation's AI policy.** Does it draw the public/enterprise distinction explicitly? Does it cover OpenAPI specs or documentation? Where is it silent?

2. **Write a one-paragraph decision rule** for your team — something concise enough to live at the top of a team wiki page. Aim for a rule that handles ambiguous cases, not just obvious ones.

3. **Hallucination practice.** Ask a public AI tool about a specific recent Laravel or PHP package version. Verify the answer against the official Laravel docs. Note where it was right, wrong, or outdated.

---

## Before you move to Module 2

Make sure you have:

- [ ] Completed the audit — you know the decision factors you'd apply in your own work
- [ ] Formed a view on the disputed Slack message — you can articulate the risk (or lack of it)
- [ ] Taken a position on Exercise 3 — and tested it against at least one challenge

In Module 2 we'll work on prompt engineering. The safety principles from Module 1 apply throughout — knowing where not to send data is as important as knowing how to prompt well.