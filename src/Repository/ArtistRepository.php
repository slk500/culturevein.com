<?php

declare(strict_types=1);

namespace Repository;

use Cocur\Slugify\Slugify;

final class ArtistRepository
{
    /**
     * @var Database
     */
    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function create(string $name): int
    {
        $slug = (new Slugify())->slugify($name);

        $stmt = $this->database->mysqli->prepare("INSERT INTO artist (name, slug) VALUES (?,?)");
        $stmt->bind_param("ss", $name, $slug);
        $stmt->execute();

        return $this->database->mysqli
            ->insert_id;
    }

    public function find(string $name): ?int
    {
        $stmt = $this->database->mysqli->prepare("SELECT artist_id FROM artist WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();

        $stmt->bind_result($artist_id);

        return $stmt->get_result()
            ->fetch_object()
            ->artist_id;
    }

    public function findAll(): array
    {
        $query = "SELECT name FROM artist ORDER BY name";

        $data = $this->database->fetch($query);

        return $data;
    }
}