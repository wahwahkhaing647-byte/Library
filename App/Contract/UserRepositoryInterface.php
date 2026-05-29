<?php

/**
 * Defines methods for retrieving and persisting user data.
 */
namespace App\Contract;

use App\DTO\UserDTO;

interface UserRepositoryInterface extends BaseInterface
{
    public function findByEmail(string $email): ?UserDTO;

}