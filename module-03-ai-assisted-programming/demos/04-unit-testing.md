# Demo 4: Unit test generation — tests that work

## Goal

Show delegates how to generate Pest/Mockery tests for a service method, run them, and refine iteratively when tests fail.

**Teaching style**: Problem-first approach, progressive building

---

## Before the demo

- Ensure you have access to an AI chat tool.
- Have an IDE ready with a Laravel project, Pest, and Mockery.
- Prepare a sample service method to test (synthetic example provided).
- Use only **synthetic** examples.

---

## Steps

**Problem-first approach**: Start with manual test writing pain

### 1. Set up the problem (2 min)

**Say:** "You need to write tests for this service method. How long does it take you to write a comprehensive test manually?"

**Show the service method** (example provided below).

**Show the pain:**
- ❌ Write test file: 2 minutes
- ❌ Set up mocks: 3 minutes
- ❌ Write happy path test: 3 minutes
- ❌ Write edge case tests: 5 minutes
- ❌ **Total: 13+ minutes** per method

**Talking point:** "Let's see how AI can generate comprehensive tests in seconds, then we'll refine them."

---

### 2. Generate basic tests (3 min)

**Show the prompt** (from `prompts/04-unit-testing-prompts.txt`):

> "Generate Pest tests with Mockery for this service method. Cover the happy path, null input, and empty string scenarios. Use PHP 8.3."

**Include the service method:**

```php
class BookService
{
    public function __construct(
        private readonly BookRepository $repository,
    ) {}

    public function findBooksByAuthor(string $author): array
    {
        if (trim($author) === '') {
            return [];
        }
        return $this->repository->findByAuthorContainingIgnoreCase($author);
    }
}
```

**Run the prompt** and show the generated tests.

**Point out:**
- ✅ Pest test structure (`it()` blocks)
- ✅ Mockery setup
- ✅ Multiple test cases (happy path, null, empty)

---

### 3. Run the tests (3 min)

**Show the generated tests** in the IDE.

**Say:** "Let's run these tests and see if they work."

**Run:** `php artisan test --filter=BookService`

**If they pass:**
- ✅ "Great! But let's add more edge cases."

**If they fail:**
- Show the failure: "One test failed. Let's see why."
- Diagnose: "The mock isn't set up correctly for the empty string case."
- **This is the key learning moment** — show iterative refinement.

---

### 4. Refine the tests (3 min)

**If tests failed, show refinement:**

**Refine prompt:**

> "Fix the test for empty string input. The service should return an empty array when author is null or empty. Update the Mockery expectations accordingly."

**Run the refined prompt** and show improved tests.

**Re-run tests** — they should pass now.

**Say:** "Test generation is iterative — generate, run, refine, repeat."

---

### 5. Add more edge cases (2 min)

**Refine prompt:**

> "Add tests for edge cases: author with only whitespace, author not found (empty result), and repository throws exception."

**Run and show additional tests.**

**Point out:**
- ✅ More comprehensive coverage
- ✅ Exception handling tested
- ✅ Edge cases covered

**Say:** "Progressive building — start with basics, add complexity."

---

### 6. Test quality checklist (2 min)

**Show the test quality checklist:**

- ✅ **Coverage:** Happy path, edge cases, exceptions?
- ✅ **Mocks:** Properly set up with Mockery?
- ✅ **Assertions:** Clear and specific with Pest `expect()`?
- ✅ **Run:** Do tests actually pass?

**Say:** "Generate tests, but always run and verify. Don't trust tests without running them."

---

## Sample service method to test

**BookService method** (synthetic):

```php
class BookService
{
    public function __construct(
        private readonly BookRepository $repository,
    ) {}

    public function findBooksByAuthor(string $author): array
    {
        if (trim($author) === '') {
            return [];
        }
        return $this->repository->findByAuthorContainingIgnoreCase($author);
    }
}
```

**Expected generated tests** (what AI should generate):

```php
use Mockery;
use function Pest\Laravel\mock;

beforeEach(function () {
    $this->repository = mock(BookRepository::class);
    $this->service = new BookService($this->repository);
});

it('returns books for a valid author', function () {
    $expectedBooks = [
        new Book(['title' => 'The Hobbit', 'author' => 'Tolkien']),
        new Book(['title' => 'The Lord of the Rings', 'author' => 'Tolkien']),
    ];

    $this->repository
        ->shouldReceive('findByAuthorContainingIgnoreCase')
        ->once()
        ->with('Tolkien')
        ->andReturn($expectedBooks);

    $result = $this->service->findBooksByAuthor('Tolkien');

    expect($result)->toHaveCount(2)
        ->and($result[0]->author)->toBe('Tolkien');
});

it('returns empty array for null input', function () {
    $this->repository->shouldNotReceive('findByAuthorContainingIgnoreCase');

    $result = $this->service->findBooksByAuthor('');

    expect($result)->toBeEmpty();
});

it('returns empty array for empty string', function () {
    $this->repository->shouldNotReceive('findByAuthorContainingIgnoreCase');

    $result = $this->service->findBooksByAuthor('');

    expect($result)->toBeEmpty();
});
```

---

## If you can't run live

- Show pre-prepared screenshots of generated tests.
- Use slides with test examples.
- Emphasize the process: generate → run → refine → verify.

---

## Teaching Tips

- **Emphasize**: Generate tests, but always run them — AI can generate tests that don't compile or don't test the right thing
- **Watch for**: Delegates who trust tests without running — show a failure example
- **Adapt**: If test generation fails, show iterative refinement process

---

## Time Allocation

- Set up problem: 2 min
- Generate basic tests: 3 min
- Run the tests: 3 min
- Refine the tests: 3 min
- Add edge cases: 2 min
- Test quality checklist: 2 min
- **Total: ~15 minutes**
