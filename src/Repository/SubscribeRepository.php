<?php

declare(strict_types=1);

namespace Repository;

use Repository\Base\Database;

final class SubscribeRepository
{
    /**
     * @var Database
     */
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function is_tag_subscribed_by_user(string $tag_slug_id, int $user_id): bool
    {
        $stmt = $this->database->mysqli->prepare(
            "SELECT EXISTS(SELECT 1 FROM subscribe_user_tag WHERE tag_slug_id = ? AND user_id = ? LIMIT 1)");

        $stmt->bind_param('si', $tag_slug_id, $user_id);
        $stmt->execute();
        $stmt->bind_result($result);
        $stmt->fetch();

        return  (bool) $result;
    }

    public function subscribe_tag(string $tag_slug_id, int $user_id)
    {
        $stmt = $this->database->mysqli->prepare("
                INSERT INTO subscribe_user_tag (tag_slug_id, user_id) VALUES (?, ?)");

        if (!$stmt) {
            throw new \Exception($this->database->mysqli->error);
        }

        $stmt->bind_param('si', $tag_slug_id, $user_id);

        if (!$stmt->execute()) {
            throw new \Exception($stmt->error);
        }
    }

    public function unsubscribe_tag(string $tag_slug_id, int $user_id)
    {
        $stmt = $this->database->mysqli->prepare("
                DELETE FROM subscribe_user_tag WHERE tag_slug_id = ? AND user_id = ? ");

        if (!$stmt) {
            throw new \Exception($this->database->mysqli->error);
        }

        $stmt->bind_param('si', $tag_slug_id, $user_id);

        if (!$stmt->execute()) {
            throw new \Exception($stmt->error);
        }
    }

    public function get_number_of_subscribers(string $tag_slug_id): int
    {
        $stmt = $this->database->mysqli->prepare("SELECT COUNT(*) FROM subscribe_user_tag WHERE tag_slug_id = ?");
        $stmt->bind_param("s", $tag_slug_id);
        $stmt->execute();
        $stmt->bind_result($number_of_subscribers);
        $stmt->fetch();

        return $number_of_subscribers;
    }
}