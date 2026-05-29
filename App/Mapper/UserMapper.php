<?php

namespace App\Mapper;

use App\DTO\UserDTO;

class UserMapper
{
    public static function toDTO(array $row): UserDTO
    {
        return new UserDTO(
            id: (int) $row['id'],
            name: $row['name'],
            email: $row['email'],
            password: $row['password']
        );
    }

    public static function toDTOList(array $rows): array
    {
        return array_map(
            fn($row) => self::toDTO($row),
            $rows
        );
    }
}