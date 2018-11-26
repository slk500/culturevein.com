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

    public function save(string $artist_name, string $artist_slug_id)
    {
        $stmt = $this->database->mysqli->prepare("INSERT INTO artist (name, artist_slug_id) VALUES (?,?)");
        $stmt->bind_param("ss", $artist_name, $artist_slug_id);
        $stmt->execute();
    }

    public function find_slug_id_by_name(string $artist_name)
    {
        $stmt = $this->database->mysqli->prepare("SELECT artist_slug_id FROM artist WHERE name = ?");
        $stmt->bind_param("s", $artist_name);
        $stmt->execute();
        $stmt->bind_result($artist_slug_id);
        $stmt->fetch();

        return  $artist_slug_id;
    }

    public function find_all(): array
    {
        $query = "SELECT name FROM artist ORDER BY name";

        $data = $this->database->fetch($query);

        return $data;
    }
}