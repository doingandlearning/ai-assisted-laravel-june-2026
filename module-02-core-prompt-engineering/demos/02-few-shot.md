# Demo 2: Few-shot — without vs. with examples

## Goal

Demonstrate how adding 1–2 examples changes output style dramatically.

**Teaching style**: Problem-first approach, progressive building

---

## Before the demo

- Open a chat interface (public or enterprise).
- Have both prompts ready (see `prompts/few-shot-examples.txt`).
- Use synthetic Laravel examples only.

---

## Steps

**Problem-first approach**: Show output without examples, then with examples

### 1. Set up the problem (1 min)

**Say:** "Sometimes you want the model to match your style. Let's see how examples help."

**Show the task:** Generate a controller that matches our team's style.

---

### 2. Zero-shot: No examples (3 min)

**Show the prompt:**

> "Generate a Laravel API controller for Product"

**Run it and show the output.**

**Point out:**

- ✅ It works, but...
- ❌ Style might not match your team
- ❌ Might use patterns you don't prefer
- ❌ Generic Laravel style

**Talking point:** "The output is correct, but it doesn't match our style."

---

### 3. Few-shot: With examples (4 min)

**Show the improved prompt:**

> "Generate a controller like this:
> ```php
> class ProductController extends Controller
> {
>     public function __construct(
>         private readonly ProductService $service,
>     ) {}
>
>     public function index(): JsonResponse
>     {
>         return response()->json($this->service->getAll());
>     }
> }
> ```
> Now generate another one for User."

**Run it and show the output.**

**Point out improvements:**

- ✅ Matches the style from the example
- ✅ Uses same patterns (constructor injection, JsonResponse)
- ✅ Same structure and formatting
- ✅ One example changed everything

**Talking point:** "Adding one example teaches the model your style."

---

### 4. Compare outputs (2 min)

**Show side-by-side:**

- Zero-shot: Generic Laravel style
- Few-shot: Matches your team's style

**Key lesson:**

- Zero-shot: Works for well-known patterns
- Few-shot: Use when you want specific style or format
- One example can change everything

**Bridge to next concept:** "Now let's see how to refine prompts when output is still wrong..."

---

## Teaching Tips

- **Emphasize**: One example is often enough — don't overdo it
- **Watch for**: Delegates who add too many examples — show that 1–2 is usually sufficient
- **Adapt**: If examples seem complex, use a simpler example (e.g. just the class structure)

---

## Time Allocation

- Set up problem: 1 min
- Zero-shot: 3 min
- Few-shot: 4 min
- Compare: 2 min
- **Total: ~10 minutes**
