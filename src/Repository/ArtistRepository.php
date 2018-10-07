<?php


namespace Repository;


use Cocur\Slugify\Slugify;

class ArtistRepository extends Database
{
    public function create(object $data): int
    {
        $stmt = $this->mysqli->prepare("SELECT music_video_id FROM music_video WHERE artist_name = ?");
        $stmt->bind_param("s", $data->artist_name);
        $stmt->execute();

        $stmt->bind_result($music_video_id);

        $music_video_id = $stmt->get_result()
            ->fetch_object()
            ->tag_id;

        if (!$music_video_id) {

            $slug = (new Slugify())->slugify($data->artist_name);

            $stmt = $this->mysqli->prepare("INSERT INTO music_video (artist_name, slug) VALUES (?,?)");
            $stmt->bind_param("ss", $data->artist_name, $slug);
            $stmt->execute();
            $music_video_id = $this->mysqli->insert_id;
        }

        return $music_video_id;
    }
}