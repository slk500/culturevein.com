<?php

declare(strict_types=1);

namespace Repository;

use Model\User;
use Repository\Base\Repository;

final class UserRepository extends Repository
{
    public function add(User $user): ?int
    {
        $stmt = $this->database->mysqli->prepare("INSERT INTO user (email, password, username) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $user->email, $user->password, $user->username);
        $stmt->execute();

        return $this->database->mysqli->insert_id;
    }

    public function find_statistics()
    {
        $query = "SELECT user_id, username, vt.video_tag_count, vtt.video_tag_time_count, v.video_count
FROM user
LEFT JOIN
  (SELECT user_id, COUNT(user_id) AS video_tag_count
  FROM video_tag GROUP BY user_id) vt USING (user_id)
LEFT JOIN
  (SELECT user_id, COUNT(user_id) AS video_tag_time_count
           FROM video_tag_time GROUP BY user_id) vtt USING (user_id)
LEFT JOIN
     (SELECT user_id, COUNT(user_id) AS video_count
      FROM video GROUP BY user_id) v USING (user_id)";

        return $this->database->fetch($query);
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
        if ($user_data) {
            $user = new User(
                $user_data->email,
                $user_data->password,
                $user_data->username
            );
            $user->user_id = $user_data->user_id;
        }

        return $user;
    }
}