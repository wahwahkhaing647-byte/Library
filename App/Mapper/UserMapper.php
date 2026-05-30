<?php

namespace App\Mapper;

use App\DTO\UserDTO;
use App\DTO\UserAuthDTO;

class UserMapper
{
    // For public usage (views, API)
    public static function toDTO(array $row): UserDTO
    {
        return new UserDTO(
            id: (int)$row['id'],
            name: $row['name'],
            email: $row['email']
        );
    }

    // For authentication (login)
  public static function toAuthDTO(array $row): UserAuthDTO
{
    return new UserAuthDTO(
        id: (int)$row['id'],
        name: $row['name'],
        email: $row['email'],
        passwordHash: $row['password']
    );
}

    public static function toDTOList(array $rows): array
    {
        return array_map(fn($r) => self::toDTO($r), $rows);
    }
}