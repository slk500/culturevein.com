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

    public function create(object $data): int
    {
        $stmt = $this->database->mysqli->prepare("SELECT artist_id FROM artist WHERE name = ?");
        $stmt->bind_param("s", $data->name);
        $stmt->execute();

        $stmt->bind_result($artist_id);

        $artist_id = $stmt->get_result()
            ->fetch_object()
            ->artist_id;

        if (!$artist_id) {

            $slug = (new Slugify())->slugify($data->name);

            $stmt = $this->database->mysqli->prepare("INSERT INTO artist (name, slug) VALUES (?,?)");
            $stmt->bind_param("ss", $data->artist_name, $slug);
            $stmt->execute();
            $artist_id = $this->mysqli->insert_id;
        }

        return $artist_id;
    }

    public function findAll(): array
    {
        $query = "SELECT name FROM artist ORDER BY name";

        $data = $this->database->fetch($query);

        return $data;
    }
}