<?php

// Sample User class for Demo 3 (Refactoring)
// Synthetic example — use for demo only

class User
{
    public function __construct(
        private readonly string $name,
        private readonly ?string $email,
        private readonly bool $active,
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function isActive(): bool
    {
        return $this->active;
    }
}
