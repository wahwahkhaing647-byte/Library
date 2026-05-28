<?php

/**
 * Defines methods for retrieving and persisting user data.
 */
namespace App\Contract;

use App\Model\User;

interface UserRepositoryInterface extends BaseInterface
{
    public function findByEmail(string $email): ?User;

}