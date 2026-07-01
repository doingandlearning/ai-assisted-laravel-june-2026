# Module 3 Demo Preparation Guide

**CRITICAL:** Module 3 is the anchor module. These demos must work.

---

## Pre-Demo Setup Checklist

### IDE Setup (Do This First)

**Create Laravel 11 Project:**

1. **Project Structure:**
   ```
   app/
   ├── Models/
   │   ├── Book.php
   │   └── User.php
   ├── Repositories/
   │   └── BookRepository.php
   └── Services/
       ├── BookService.php
       └── UserService.php

   tests/
   ├── Unit/
   │   ├── BookServiceTest.php
   │   └── UserServiceTest.php
   └── Pest.php
   ```

2. **Dependencies** (`composer.json`):
   - Laravel 11
   - Pest (`pestphp/pest`)
   - Mockery (included with Laravel)
   - PHP 8.3

3. **Classes to Create:**

   **Book.php** - Use `code-samples/Book.php` as template
   **User.php** - Use `code-samples/User.php` as template
   **BookRepository.php** - Class with `findByAuthorContainingIgnoreCase(string $author): array`
   **BookService.php** - Service with `findBooksByAuthor` method (see Demo 4)
   **UserService.php** - Service with `getActiveUserEmails` method (see Demo 3)

4. **Test Classes:**
   - **BookServiceTest.php** - Empty initially, will generate in Demo 4
   - **UserServiceTest.php** - Has Pest test for `getActiveUserEmails` (see Demo 3)

5. **VERIFY:**
   - [ ] Project runs (`php artisan serve` or Laravel Herd)
   - [ ] All classes exist
   - [ ] Tests run (`php artisan test`)
   - [ ] Can run tests in VS Code with PHP Intelephense

---

## Demo-by-Demo Preparation

### Demo 1: Laravel Generation

**What You Need:**
- [ ] AI chat tool open (GitHub Copilot for Business or approved tool)
- [ ] Prompts ready (from `prompts/01-laravel-generation-prompts.txt`)
- [ ] IDE open with Laravel project
- [ ] New namespace ready for generated code (or paste location)

**Test Beforehand:**
- [ ] Run Prompt 1 - Does it generate good model + migration?
- [ ] Run Prompt 2 - Does it generate repository + service?
- [ ] Run Prompt 3 - Does refinement work?
- [ ] Time yourself - Does it fit in 15 min?

**Backup:**
- [ ] Screenshots of all three prompts and outputs
- [ ] Generated code saved in files
- [ ] Can show slides if live fails

---

### Demo 2: Legacy Explanation

**What You Need:**
- [ ] AI chat tool open
- [ ] Legacy code snippet ready (from `code-samples/LegacyUserBean.php`)
- [ ] Prompts ready (from `prompts/02-legacy-explanation-prompts.txt`)

**Test Beforehand:**
- [ ] Run all 4 prompts with legacy code
- [ ] Verify explanations are helpful
- [ ] Time yourself - Does it fit in 15 min?

**Backup:**
- [ ] Screenshots of all 4 layers of explanation
- [ ] Pre-written explanations (if AI fails)
- [ ] Can show slides with explanations

---

### Demo 3: Refactoring (CRITICAL - Most Complex)

**What You Need:**
- [ ] IDE open with UserService class
- [ ] Original verbose method in UserService
- [ ] Pest test that PASSES with original code
- [ ] AI chat tool open
- [ ] Prompt ready (from `prompts/03-refactoring-prompts.txt`)

**CRITICAL Setup Steps:**

1. **Create UserService.php:**
   ```php
   class UserService
   {
       public function getActiveUserEmails(array $users): array
       {
           $emails = [];
           foreach ($users as $user) {
               if ($user !== null && $user->isActive() && trim((string) $user->getEmail()) !== '') {
                   $emails[] = $user->getEmail();
               }
           }
           return $emails;
       }
   }
   ```

2. **Create UserServiceTest.php:**
   ```php
   it('returns only active users with email', function () {
       $service = new UserService();

       $users = [
           new User('John', 'john@example.com', true),
           new User('Jane', 'jane@example.com', false),
           new User('Bob', '', true),
           null,
       ];

       $emails = $service->getActiveUserEmails($users);

       expect($emails)->toHaveCount(1)
           ->and($emails[0])->toBe('john@example.com');
   });
   ```

3. **VERIFY TEST PASSES** with original code

4. **Test Refactoring:**
   - Run prompt to generate refactored code
   - Replace method in IDE
   - Run test - does it still pass?
   - If not, refine prompt and try again

**Test Beforehand:**
- [ ] Original code runs
- [ ] Test passes with original code
- [ ] Refactored code runs
- [ ] Test passes with refactored code
- [ ] Time yourself - Does it fit in 15 min?

**Backup:**
- [ ] Screenshots of before/after code
- [ ] Screenshot of test passing before
- [ ] Screenshot of test passing after
- [ ] Can show slides if IDE fails

---

### Demo 4: Unit Testing (CRITICAL - High Tech Dependency)

**What You Need:**
- [ ] IDE open with BookService class
- [ ] BookService has `findBooksByAuthor` method
- [ ] BookRepository class exists
- [ ] Pest and Mockery configured
- [ ] AI chat tool open
- [ ] Prompts ready (from `prompts/04-unit-testing-prompts.txt`)

**CRITICAL Setup Steps:**

1. **Verify BookService exists:**
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

2. **Verify BookRepository exists:**
   ```php
   class BookRepository
   {
       public function findByAuthorContainingIgnoreCase(string $author): array
       {
           // Implementation for demo
       }
   }
   ```

3. **Create empty test file:**
   ```php
   // tests/Unit/BookServiceTest.php
   // Will generate tests here
   ```

**Test Beforehand:**
- [ ] Run Prompt 1 - Do generated tests run?
- [ ] Do generated tests pass?
- [ ] If not, test Prompt 2 (refinement)
- [ ] Time yourself - Does it fit in 15 min?

**Backup:**
- [ ] Screenshots of generated tests
- [ ] Pre-written tests that work
- [ ] Can show slides if IDE fails

---

## Prerequisites for Delegates

- **PHP 8.3** via Laravel Herd, Homebrew, or system install
- **Composer** for dependency management
- **VS Code** with PHP Intelephense (or PhpStorm)
- **Laravel Herd** (recommended for local Laravel development on macOS/Windows)
- **GitHub Copilot** access (or approved AI tool)

---

## Demo Execution Tips

### If Demo Goes Wrong:

**Demo 1 (Generation):**
- If output is poor → "This is why we review! Let me refine..."
- Show refinement process
- Emphasize iterative improvement

**Demo 2 (Explanation):**
- If explanation is wrong → "This is why we verify! Let me check..."
- Show how to verify explanation
- Emphasize explanation is starting point

**Demo 3 (Refactoring):**
- If test fails → "Perfect! This is why we test! Let me fix..."
- Show refinement process
- Emphasize safety-first approach

**Demo 4 (Testing):**
- If tests don't run → "This happens! Let me refine..."
- Show refinement process
- Emphasize iterative test generation

### If Tech Fails:

- Stay calm
- Use backup screenshots
- Explain conceptually
- "Let me show you what should happen..."
- Move to next demo

---

## Time Management

**Total Demo Time:** ~60 minutes (4 demos × 15 min)

**If Running Behind:**
- Demo 1: Can trim to 10 min (skip refinement)
- Demo 2: Can trim to 10 min (skip risk analysis)
- Demo 3: Keep full - most important
- Demo 4: Can trim to 10 min (skip edge cases)

**If Running Ahead:**
- Add more examples
- Show more refinement rounds
- Let delegates try prompts themselves

---

## Success Criteria

**Demo 1 Success:**
- ✅ Shows generation is fast
- ✅ Shows refinement process
- ✅ Shows review checklist

**Demo 2 Success:**
- ✅ Shows layered explanation approach
- ✅ Shows how to understand legacy code
- ✅ Shows migration path

**Demo 3 Success:**
- ✅ Shows test-first refactoring
- ✅ Shows safety approach
- ✅ Shows before/after comparison

**Demo 4 Success:**
- ✅ Shows test generation
- ✅ Shows iterative refinement
- ✅ Shows running tests is essential

---

## Final Check Before Delivery

- [ ] All code runs
- [ ] All tests pass
- [ ] All prompts tested
- [ ] All demos timed
- [ ] Backup materials ready
- [ ] IDE ready to show
- [ ] AI tool access confirmed

**You're ready!** 🚀
