# Demo 1: Public vs. enterprise — same prompt, different context

## Goal

Show delegates that **where** you run the same prompt (public vs. enterprise) matters for data handling, and sometimes for behaviour or features.

**Teaching style**: Problem-first approach, progressive building

---

## Before the demo

- Ensure you can show both environments (e.g. browser tab for public ChatGPT, another for GitHub Copilot for Business with org sign-in).
- If you only have one, use a slide with two screenshots and talk through the differences.
- Use only **synthetic** examples (no real internal code or APIs).

---

## Steps

**Problem-first approach**: Start by showing the confusion

### 1. Set up the problem (2 min)

**Say:** "Imagine you want to ask about Laravel route model binding. You have two options: public ChatGPT or your org's GitHub Copilot for Business. Which do you use? Does it matter?"

**Show the confusion:**
- ❌ "They're both AI tools, right?"
- ❌ "The answer will be the same either way"
- ❌ "Does it really matter where I paste it?"

**Talking point:** "Let's see what happens when we use the same prompt in both places."

---

### 2. Show the prompt (1 min)

Use the same neutral, technical prompt in both places. Example (see `prompts/same-prompt.txt`):

> "In one short paragraph, explain the difference between route model binding and manual ID lookup in a Laravel API controller. We use Laravel 11 and PHP 8.3."

**Say:** "This is a generic question about public APIs. Let's see what happens in both places."

---

### 3. Run it in the public tool — show the "problem" (3 min)

**Progressive building**: Show what happens, then explain why it's a problem

Paste and submit. Show the answer.

**Say:** "Good answer, right? But here's the problem..."

**Point out:**
- ✅ The answer is correct and helpful
- ❌ This request and response are stored on the provider's side
- ❌ "What if I had pasted our internal API spec instead? That would be a compliance risk."

**Talking point:** "The answer is fine, but the **context** matters. Where is this data going?"

---

### 4. Run the same prompt in the enterprise tool — show the "solution" (3 min)

Paste and submit in GitHub Copilot for Business (or your org's approved tool).

**Say:** "Same question, same answer quality. But now..."

**Point out:**
- ✅ Same prompt, same answer quality
- ✅ It's in our tenant, not the provider's
- ✅ "If I had added internal API names or proprietary code, that would stay in our environment, not the provider's."

**Talking point:** "The skill of prompting is the same. The **rules** about where you prompt — public vs. enterprise — are what protect our data and our compliance."

---

### 5. Highlight the lesson (2 min)

**Progressive building**: Build from simple to complex understanding

- **Same prompt, same kind of answer** → The skill is the same
- **Different context**: who stores the data, and what you're allowed to send → The rules are different
- **For internal or proprietary details**, use only the environment your org has approved → The solution

**Bridge to next concept:** "Now that we know **where** to use AI safely, let's talk about **when** we can trust what it tells us..."

---

## If you can't run both live

- Show two pre-prepared screenshots (same prompt, two UIs).
- Read the "public" and "enterprise" policies from your org (or generic) and map them to "what can I paste here?"
- Use the problem-first approach: show the confusion, then explain the distinction.

---

## Teaching Tips

- **Emphasize**: This isn't about fear — it's about practical safety
- **Watch for**: Delegates who think "it doesn't matter" — use concrete examples
- **Adapt**: If privacy feels abstract, use more concrete scenarios (e.g. "Would you paste your password? No. Same principle.")

---

## Time Allocation

- Set up problem: 2 min
- Show prompt: 1 min
- Public tool demo: 3 min
- Enterprise tool demo: 3 min
- Lesson summary: 2 min
- **Total: ~11 minutes**
