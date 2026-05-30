<?php

namespace App\DTO;

class UserDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
      
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

   
}