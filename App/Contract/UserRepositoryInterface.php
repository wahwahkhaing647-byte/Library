<?php

/**
 * Defines methods for retrieving and persisting user data.
 */
namespace App\Contract;

use App\DTO\UserDTO;
use App\DTO\UserAuthDTO;

interface UserRepositoryInterface extends BaseInterface
{
    public function findByEmail(string $email): ?UserAuthDTO;

}