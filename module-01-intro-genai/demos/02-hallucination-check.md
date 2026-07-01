# Demo 2: Hallucination check — spot and correct

## Goal

Show that models can produce **plausible but wrong** answers (hallucinations), and that delegates should verify critical facts rather than trust blindly.

**Teaching style**: Problem-first approach, progressive building, show what goes wrong

---

## Before the demo

- Open a chat interface (public or enterprise; use only synthetic examples).
- Have the correct answer to hand (e.g. from official docs) so you can show "verify".
- Prepare to show the Laravel docs or php.net for verification.

---

## Steps

**Problem-first approach**: Show what goes wrong before explaining how to fix it

### 1. Set up the problem (2 min)

**Say:** "Models don't 'know' they're wrong. They're good at sounding confident. Let's see what happens when we ask something that can easily be wrong."

**Show the confusion:**
- ❌ "It sounds confident, so it must be right"
- ❌ "It gave me code, so it must work"
- ❌ "Why would it lie?"

**Talking point:** "Let's test this with a question where we can easily check the answer."

---

### 2. Use a prompt that invites hallucination (1 min)

**Progressive building**: Start with the simplest example

Use one from `prompts/hallucination-prompts.txt`:

- **Wrong premise:** "Summarise the breaking changes in Laravel 12.4." (12.4 may not exist yet; model may invent.)

**Say:** "Laravel 12.4 might not exist yet, or might be very new. Let's see what the model says."

---

### 3. Show the "bad" answer — the problem (3 min)

**Problem-first**: Show what goes wrong

Read or skim the model's response. Point out:

- ❌ It looks confident and structured
- ❌ It might mix versions, or invent a method name, or get the package wrong
- ❌ It doesn't say "I'm not sure" — it just makes something up

**Say:** "This looks plausible, right? But we don't know if it's true. This is a hallucination."

**Show the problem explicitly:**
- "If I used this code, what would happen?"
- "If I based a decision on this, what's the risk?"

---

### 4. Show how to verify — the solution (3 min)

**Progressive building**: Show the verification process step by step

Open the real docs (or a known-good source) and compare:

**Step 1:** "Here's what the model said..."
- Read one claim from the model's answer

**Step 2:** "Here's what the docs say..."
- Show the official documentation
- Point out the difference

**Step 3:** "For anything that affects behaviour or security, we check."
- ✅ Always verify versions
- ✅ Always verify API signatures
- ✅ Always verify security-sensitive code

**Talking point:** "This is why we 'trust but verify' — especially for production code."

---

### 5. Build to more complex examples (optional, 2 min)

**Progressive building**: Add complexity

If time allows, try another prompt:

- **Very recent or niche:** "What's the exact signature of `JsonResponse::fromJsonString()` in Laravel 11?"

**Show:**
- Even "simple" questions can be wrong if the model's knowledge is outdated
- Version numbers are easy to get wrong
- API signatures matter for compilation

---

### 6. Summarise — the lesson (1 min)

**Key takeaway:**

"Hallucinations aren't rare edge cases — they're normal. Trust but verify. For syntax, versions, and APIs — especially for security or production — always confirm."

**Bridge to next concept:** "Now that we know to verify, let's talk about **when** to rely on AI vs. when to double-check..."

---

## Alternative prompts (synthetic only)

- Ask for "the latest version of library X" (model may be past cut-off).
- Ask for a "citation" or "link" to an internal doc (model may invent a URL).
- Ask about a very recent feature that may not exist yet.

---

## Teaching Tips

- **Emphasize**: This isn't about avoiding AI — it's about using it wisely
- **Watch for**: Delegates who become overly cautious — reassure that verification is normal
- **Adapt**: If hallucinations seem theoretical, run the demo live and show real docs comparison
- **Progressive building**: Start with obvious examples, then build to subtle ones

---

## Time Allocation

- Set up problem: 2 min
- Show prompt: 1 min
- Show "bad" answer: 3 min
- Show verification: 3 min
- Complex example (optional): 2 min
- Summary: 1 min
- **Total: ~10-12 minutes**
