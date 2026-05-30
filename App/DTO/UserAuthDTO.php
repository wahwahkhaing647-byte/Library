<?php

namespace App\DTO;

class UserAuthDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public string $passwordHash
    ) {}
}