# Demo 2: Legacy code explanation — understanding the unknown

## Goal

Show delegates how AI can explain legacy code (pre-framework PHP, procedural classes) step by step, identify dependencies, and suggest modern equivalents.

**Teaching style**: Problem-first approach, progressive building

---

## Before the demo

- Ensure you have access to an AI chat tool.
- Prepare a synthetic legacy code snippet (`code-samples/LegacyUserBean.php` — verbose, old patterns).
- Use only **synthetic** examples (not real internal code).

---

## Steps

**Problem-first approach**: Start with confusion

### 1. Set up the problem (2 min)

**Say:** "You've inherited this legacy code. You don't understand what it does, and you're afraid to touch it. Sound familiar?"

**Show the legacy code snippet** (from `code-samples/LegacyUserBean.php`).

**Show the pain:**
- ❌ Verbose, old patterns
- ❌ No comments or documentation
- ❌ Don't know what it does
- ❌ Don't know what breaks if changed

**Talking point:** "Let's use AI to understand it before we change it."

---

### 2. Layer 1: "What does this do?" (3 min)

**Show the prompt** (from `prompts/02-legacy-explanation-prompts.txt`):

> "Explain what this code does step by step. Break down each part and explain the functionality."

**Run the prompt** and show the explanation.

**Point out:**
- ✅ AI explains the functionality
- ✅ Breaks down complex logic
- ✅ Identifies key components

**Say:** "First, we understand what it does. Then we can think about why it was written this way."

---

### 3. Layer 2: "Why was it written this way?" (3 min)

**Refine the prompt:**

> "Why might this code have been written this way? What patterns or frameworks does it use? What was common at the time?"

**Run and show explanation.**

**Point out:**
- ✅ Historical context (pre-framework PHP, manual validation beans)
- ✅ Patterns used (why verbose getters/setters?)
- ✅ Dependencies identified

**Say:** "Understanding the 'why' helps us plan modernization."

---

### 4. Layer 3: "What's the modern equivalent?" (3 min)

**Refine the prompt:**

> "What would be the modern Laravel 11 equivalent of this code? Show a simple example using a Form Request for validation."

**Run and show modern equivalent.**

**Point out:**
- ✅ Modern Laravel patterns (Form Requests, typed properties)
- ✅ Simpler, cleaner code
- ✅ Same functionality, different approach

**Say:** "Now we have a migration path — we know what the modern version looks like."

---

### 5. Layer 4: "What are the risks?" (2 min)

**Refine the prompt:**

> "What are the risks or dependencies if I try to refactor this code? What might break?"

**Run and show risk analysis.**

**Point out:**
- ✅ Dependencies identified
- ✅ Potential breaking changes
- ✅ Testing recommendations

**Say:** "Understanding risks helps us plan safe refactoring."

---

### 6. Summary: From confusion to understanding (2 min)

**Show the progression:**
1. **What does it do?** → Functional understanding
2. **Why was it written this way?** → Historical context
3. **What's the modern equivalent?** → Migration path
4. **What are the risks?** → Safety planning

**Say:** "AI doesn't replace understanding — it accelerates it. Use explanation to plan changes safely."

---

## Sample legacy code snippet

**Example legacy procedural PHP** (synthetic — see `code-samples/LegacyUserBean.php`):

```php
class LegacyUserBean
{
    private $firstName;
    private $lastName;
    private $errors = array();

    public function validateUser()
    {
        $this->errors = array();
        if ($this->firstName == null || trim($this->firstName) == '') {
            $this->errors[] = 'First name is required';
        }
        if ($this->lastName == null || trim($this->lastName) == '') {
            $this->errors[] = 'Last name is required';
        }
    }

    public function isValid()
    {
        return count($this->errors) == 0;
    }
}
```

**Use this or create your own synthetic example** — keep it simple enough to explain in demo time.

---

## If you can't run live

- Show pre-prepared screenshots of the prompts and explanations.
- Use slides with the layered explanations.
- Emphasize the process: what → why → modern equivalent → risks.

---

## Teaching Tips

- **Emphasize**: Explanation is a starting point — verify by reading code yourself
- **Watch for**: Delegates who want to skip understanding and jump to refactoring — emphasize safety
- **Adapt**: If legacy code is too complex, use simpler examples

---

## Time Allocation

- Set up problem: 2 min
- Layer 1 (what): 3 min
- Layer 2 (why): 3 min
- Layer 3 (modern equivalent): 3 min
- Layer 4 (risks): 2 min
- Summary: 2 min
- **Total: ~15 minutes**
