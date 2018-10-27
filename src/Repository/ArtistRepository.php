<?php

declare(strict_types=1);

namespace Repository;

use Cocur\Slugify\Slugify;
use Repository\Base\Database;

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

    public function create(string $artist_name): int
    {
        $slug = (new Slugify())->slugify($artist_name);

        $stmt = $this->database->mysqli->prepare("INSERT INTO artist (name, slug) VALUES (?,?)");
        $stmt->bind_param("ss", $artist_name, $slug);
        $stmt->execute();

        return $this->database->mysqli
            ->insert_id;
    }

    public function find(string $artist_name)
    {
        $stmt = $this->database->mysqli->prepare("SELECT artist_id FROM artist WHERE name = ?");
        $stmt->bind_param("s", $artist_name);
        $stmt->execute();
        $stmt->bind_result($artist_id);
        $stmt->fetch();

        return  $artist_id;
    }

    public function find_all(): array
    {
        $query = "SELECT name FROM artist ORDER BY name";

        $data = $this->database->fetch($query);

        return $data;
    }
}