<?php

namespace App\Repository;

use App\Contract\UserRepositoryInterface;
use App\Mapper\UserMapper;
use App\DTO\UserDTO;
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
   public function findByEmail(string $email): ?UserDTO
    {
        $stmt = $this->db->prepare(
            "CALL sp_find_user_by_email(:email)"
        );

        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt->closeCursor();

        if (!$data) {
            return null;
        }

        // Convert array → DTO
        return UserMapper::toDTO($data);
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