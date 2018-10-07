<?php

namespace Repository;

class VideoRepository extends Database
{
    public function create()
    {
        $stmt = $this->mysqli->prepare("INSERT INTO video (youtube_id, title_pl, duration, slug, release_date, type, state) VALUES (?,?,?,?,?,3,1)");
        $stmt->bind_param("ssiss", $youtube_id, $music_video_title, $duration, $music_video_title_slug, $release_date);
        $stmt->execute();
        $stmt->close();

        return $this->mysqli->insert_id;
    }

    public function find(string $youTubeId)
    {
        $stmt = $this->mysqli->prepare( "SELECT video.name, video.release_date,video.
            youtube_id, video.duration, artist.artist_name
            FROM video
            LEFT JOIN artist_video USING (video_id)
            LEFT JOIN artist USING (music_video_id)
            WHERE video.youtube_id = ?");

        $stmt->bind_param("s", $youTubeId);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $stmt->free_result();
        $stmt->close();

        return $data;
    }

    public function findAll()
    {
        $query = "SELECT youtube_id, artist.artist_name, video.name
                FROM video
                LEFT JOIN artist_video USING (video_id)
                LEFT JOIN artist USING (music_video_id)
                ORDER BY artist_name, name";

        $data = $this->fetch($query);

        return $data;
    }

    public function withHighestNumberOfTags()
    {
        $query = "SELECT artist.artist_name, video.name, count(DISTINCT tag.tag_id) AS count,
              video.youtube_id
              FROM tag
              JOIN tag_video USING (tag_id)
              JOIN video USING (video_id)
              LEFT JOIN artist_video USING (video_id)
              LEFT JOIN artist USING (music_video_id)
              GROUP BY video.youtube_id
              ORDER BY `count` DESC
              LIMIT 10";

        $data = $this->fetch($query);

        return $data;
    }

    public function lastAdded()
    {
        $query = "SELECT video.youtube_id,
                artist.artist_name, video.name
                FROM video
                LEFT JOIN artist_video USING (video_id)
                LEFT JOIN artist USING (music_video_id)
                ORDER BY video.create_time DESC
                LIMIT 10";

        $data = $this->fetch($query);

        return $data;
    }
}
