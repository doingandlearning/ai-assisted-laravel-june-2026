# Core Prompt Engineering Principles

**Module 2 — Core Prompt Engineering**

---

## Learning objectives

By the end of this module you will be able to:

- Write developer-focused prompts that are clear, contextual, and constrained
- Apply zero-shot, few-shot, and chain-of-thought prompting appropriately
- Iteratively refine prompts when output is wrong or incomplete
- Use these techniques for technical problem-solving in chat tools

---

## Bridge from Module 1

**What we learned last time:**

- **Where** to use AI (public vs. enterprise)
- **When** to trust vs. verify

---

**The problem:**

- ❌ You've tried asking AI for help, but the answer was too vague
- ❌ It didn't understand your context
- ❌ It gave you something that doesn't fit your codebase
- ❌ You don't know how to fix it

**Today:** Learn **how** to prompt effectively.

---

## The developer's prompt: the problem

**Bad prompt example:**

> "Write some code for Laravel"

**Problems:**

- ❌ Too vague — what kind of code?
- ❌ No context — which version? What's the task?
- ❌ No constraints — what style? What patterns?

**Result:** Generic, unusable output

---

## The developer's prompt: three Cs

---

**Clarity** — What do you want?

- Task: generate, explain, refactor, test
- Format: code block, inline, with comments

---

**Context** — What does the model need to know?

- Stack: Laravel 11, PHP 8.3, Eloquent
- File: "In the UsersController class"
- Current state: "This method already exists"

---

**Constraints** — What are the rules?

- Language: PHP 8.3 style
- Style: Follow Laravel best practices
- Don'ts: "Don't use the `app()` helper for dependency injection"

---

## Clarity: task and format

**Example — vague:**

> "Write a controller"

---

**Example — clear:**

> "Generate a Laravel API controller with one GET endpoint that returns a list of users"

**Better:**

- ✅ Task: Generate
- ✅ What: API controller
- ✅ Format: GET endpoint, returns list

---

## Context: stack, file, constraints

**Example — no context:**

> "Generate a controller"

---

**Example — with context:**

> "Generate a Laravel 11 API controller using PHP 8.3. The endpoint should return JsonResponse with User models. I'm working in the UsersController class."

**Better:**

- ✅ Stack: Laravel 11, PHP 8.3
- ✅ File: UsersController
- ✅ Return type: JsonResponse

---

## Constraints: language, style, don'ts

**Example — no constraints:**

> "Generate a Laravel controller"

---

**Example — with constraints:**

> "Generate a Laravel 11 API controller using PHP 8.3. Use constructor injection via the service container (not the `app()` helper), return JsonResponse, and include proper error handling. Use typed method returns and avoid nullable controller responses."

**Better:**

- ✅ Style: Constructor injection via service container
- ✅ Patterns: JsonResponse, error handling
- ✅ Don'ts: No service-locator style access

---

## Zero-shot prompting

**What is zero-shot?**

Just ask, no examples.

---

**Example:**

> "Explain what `Route::resource()` does in Laravel and what routes it generates"

**When to use:**

- ✅ Well-known concepts
- ✅ Quick answers
- ✅ Standard patterns

**Limitation:**

- ❌ May not match your style or needs

---

## Few-shot prompting

**What is few-shot?**

Add 1–2 examples to guide style.

---

**Example:**

> "We write a controller like this:
>
> ```php
> class ProductController extends Controller
> {
>     public function __construct(
>         private readonly ProductService $service,
>     ) {}
> }
> ```
>
> Now generate another one for User."

---

**When to use:**

- ✅ When you want specific style
- ✅ When format matters
- ✅ One example can change everything

---

## Chain-of-thought prompting

**What is chain-of-thought?**

Ask for step-by-step reasoning.

---

**Example:**

> "Refactor this method. First explain what it does, then suggest improvements step by step, then show the refactored code."

**When to use:**

- ✅ Complex tasks
- ✅ When accuracy matters
- ✅ Debugging or design decisions

---

## When to use which technique

| Technique        | Use when                               |
| ---------------- | -------------------------------------- |
| Zero-shot        | Well-known patterns, quick answers     |
| Few-shot         | You want specific style or format      |
| Chain-of-thought | Complex refactoring, debugging, design |

**Progressive building:** Start simple (zero-shot), add complexity as needed.

---

## Iterative refinement: the problem

**Demo:** Run a vague prompt, show poor output

**Problems:**

- ❌ Output doesn't match your needs
- ❌ Missing context or constraints
- ❌ Wrong style or patterns

**Question:** How do you fix it?

---

## Iterative refinement: read the output

**Diagnosis:**

1. **What's missing?** — Identify gaps
2. **What's wrong?** — Spot issues
3. **What would make this better?** — Think about improvements

---

**Example:**

- Output uses `app()` helper for DI → Missing constraint
- Output uses Laravel 8 patterns → Missing context (we use Laravel 11)
- Output doesn't match our style → Need few-shot example

---

## Iterative refinement: refine the prompt

**Add missing context:**

> "I'm using Laravel 11, not Laravel 8"

---

**Tighten instructions:**

> "Use constructor injection via the service container, not the `app()` helper"

**Add examples:**

> "Like this: [example]"

**Add constraints:**

> "Use JsonResponse with typed returns and proper error handling"

---

## Iterative refinement: re-run and compare

**Before:** Vague prompt → Generic output

**After:** Clear prompt with context and constraints → Targeted output

---

**Key point:**

Prompting is iterative, not one-shot.

**Practice:** Refine based on output until it works.

---

## Summary

1. **Clarity**: Task + format
2. **Context**: Stack + file + constraints
3. **Constraints**: Language + style + don'ts
4. **Techniques**: Zero-shot, few-shot, chain-of-thought
5. **Iterative**: Refine based on output

---

## Bridge to Module 3

**What we've learned:**

- **How** to prompt effectively (3Cs, techniques, iteration)

**What's next:**

**Module 3**: AI-Assisted Laravel/PHP Development — **what** to prompt for (code generation, explanation, refactoring, testing).

Apply the 3Cs and iterative refinement throughout.

---

# Questions?

_Module 2 — Core Prompt Engineering Principles_
