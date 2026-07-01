# Demo 3 (optional): Model comparison — right tool for the job

## Goal

Illustrate that different models can give different **style** or **depth** on the same coding question, reinforcing “which tool for which job”.

## When to use

- You have time and access to two models (e.g. Copilot vs. ChatGPT, or GPT-4 vs. Claude).
- You want to make “model choice” concrete without going into vendor comparison.

## Before the demo

- Same coding prompt in two tabs (or two tools).
- Use a neutral, technical question (see `prompts/model-comparison-prompt.txt`).

## Steps

1. **Introduce the prompt**  
   One clear coding question, e.g.:  
   “Write a small PHP function that takes an array of strings and returns an associative array of string → length, using only built-in PHP functions. Prefer PHP 8.3 style if applicable.”

2. **Run in model A**  
   Show the answer: style, use of `array_map` vs. foreach, null handling.

3. **Run the same prompt in model B**  
   Show the answer. Compare:
   - Correctness (e.g. both correct, or one has an edge case).
   - Style (verbose vs. concise, older PHP patterns vs. PHP 8.3).
   - Extra explanation (one might add comments or caveats).

4. **Draw the lesson**  
   “Same ask, different flavour. In practice you might prefer one model for quick snippets and another for explanations or refactors. The point is: the **prompt** is the same; the **tool** is a choice.”

## Keep it short

- One prompt, two outputs, 2–3 minutes comparison.
- Avoid turning this into a “which model is better” debate; focus on “fit for task and policy”.

## Talking point

> “We’re not picking a single winner. We’re learning that model and context matter — and that our prompting skill carries across tools.”
