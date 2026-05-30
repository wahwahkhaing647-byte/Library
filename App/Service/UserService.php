<?php

namespace App\Service;

use App\Contract\UserRepositoryInterface;
use App\DTO\UserDTO;
use App\Mapper\UserMapper;
use App\Repository\UserRepository;

class UserService
{
    public function __construct(
        private UserRepositoryInterface $repo
    ) {}

    public function getUserById(int $id): ?UserDTO
    {
        $row = $this->repo->findById($id);

        return $row ? UserMapper::toDTO($row) : null;
    }

    public function getAllUsers(): array
    {
        return UserMapper::toDTOList(
            $this->repo->findAll()
        );
    }

    public function register(array $data): void
    {
        if ($this->repo->findByEmail($data['email'])) {
            throw new \RuntimeException(json_encode([
                'email' => 'Email already exists'
            ]));
        }

        $data['password'] = password_hash(
            $data['password'],
            PASSWORD_DEFAULT
        );

        $this->repo->create($data);
    }

    // 🔐 LOGIN USES UserAuthDTO
    public function login(array $data): UserDTO
    {
        if (empty($data['email']) || empty($data['password'])) {
            throw new \RuntimeException(json_encode([
                'general' => 'Email and password required'
            ]));
        }

        $user = $this->repo->findByEmail($data['email']);

        if (
            !$user ||
            !password_verify($data['password'], $user->passwordHash)
        ) {
            throw new \RuntimeException(json_encode([
                'general' => 'Invalid email or password'
            ]));
        }

        // return safe DTO
        return new UserDTO(
            id: $user->id,
            name: $user->name,
            email: $user->email
        );
    }

    public function logout(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        unset(
            $_SESSION['user_id'],
            $_SESSION['user_name'],
            $_SESSION['user_email']
        );

        session_destroy();
    }
}