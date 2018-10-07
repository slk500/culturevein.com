<?php


namespace Repository;


use Cocur\Slugify\Slugify;

class ArtistRepository extends Database
{
    public function create(object $data): int
    {
        $stmt = $this->mysqli->prepare("SELECT artist_id FROM artist WHERE name = ?");
        $stmt->bind_param("s", $data->name);
        $stmt->execute();

        $stmt->bind_result($artist_id);

        $artist_id = $stmt->get_result()
            ->fetch_object()
            ->artist_id;

        if (!$artist_id) {

            $slug = (new Slugify())->slugify($data->name);

            $stmt = $this->mysqli->prepare("INSERT INTO artist (name, slug) VALUES (?,?)");
            $stmt->bind_param("ss", $data->artist_name, $slug);
            $stmt->execute();
            $artist_id = $this->mysqli->insert_id;
        }

        return $artist_id;
    }
}