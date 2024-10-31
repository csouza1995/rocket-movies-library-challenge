<?php

class User
{
    public ?int $id = null;
    public ?string $name = null;
    public ?string $surname = null;
    public ?string $email = null;
    public ?string $password = null;
    public ?string $avatar = null;

    public function fullname(): string
    {
        return "{$this->name} {$this->surname}";
    }

    public function avatar(): string
    {
        return $this->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($this->fullname());
    }
}
