<?php

declare(strict_types=1);


namespace Repository;


use Model\User;
use Repository\Base\Database;

class UserRepository
{
    /**
     * @var Database
     */
    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function create(User $user): ?int
    {
        $stmt = $this->database->mysqli->prepare("INSERT INTO user (email, password, username) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $user->email, $user->password, $user->username);
        $stmt->execute();

        $user_id = $this->database->mysqli->insert_id;

        return $user_id;
    }

    public function find(string $email): ?User
    {
        $stmt = $this->database->mysqli->prepare("
        SELECT *
        FROM user
        WHERE email = ?
        ");

        $stmt->bind_param('s', $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $user_data = mysqli_fetch_object($result);

        $user = null;
        if($user_data){
            $user = new User(
                $user_data->email,
                $user_data->password,
                $user_data->username
            );
            $user->user_id = $user_data->user_id;
        }

        $stmt->free_result();
        $stmt->close();

        return $user;
    }
}