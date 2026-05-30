<?php

namespace App\Repository;

use App\Contract\UserRepositoryInterface;
use App\Mapper\UserMapper;
use App\DTO\UserDTO;
use App\DTO\UserAuthDTO;
use PDO;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
        

    protected array $fillable = [
        'name',
        'email',
        'password'
    ];

    protected string $table = 'users';
    protected string $primaryKey = 'id';
    

    /*
    |--------------------------------------------------------------------------
    | FIND BY EMAIL (RETURN MODEL)
    |--------------------------------------------------------------------------
    */
  public function findByEmail(string $email): ?UserAuthDTO
{
    $stmt = $this->db->prepare(
        "SELECT * FROM users WHERE email = ? LIMIT 1"
    );

    $stmt->execute([$email]);

    $row = $stmt->fetch(\PDO::FETCH_ASSOC);

    return $row ? UserMapper::toAuthDTO($row) : null;
}
    

    /*
    |--------------------------------------------------------------------------
    | CREATE USER (ACCEPT DATA ARRAY)
    |--------------------------------------------------------------------------
    */
    // public function create(array $data): int
    // {
    //     $stmt = $this->db->prepare("
    //     INSERT INTO users (name, email, password)
    //     VALUES (:name, :email, :password)
    // ");

    //     $stmt->execute([
    //         ':name' => $data['name'],
    //         ':email' => $data['email'],
    //         ':password' => $data['password'],
    //     ]);

    //     return (int) $this->db->lastInsertId();
    // }
}