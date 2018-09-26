<?php

namespace Repository;

class VideoRepository extends BaseRepository
{
    public function find(string $youTubeId)
    {
        $stmt = $this->mysqli->prepare( "SELECT video.name, video.release_date,video.
            youtube_id, video.duration, artist.artist_name
            FROM video
            LEFT JOIN artist_video ON artist_video.video_id = video.video_id
            LEFT JOIN artist ON artist.music_video_id = artist_video.music_video_id
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
                LEFT JOIN artist_video ON artist_video.video_id = video.video_id
                LEFT JOIN artist ON artist.music_video_id = artist_video.music_video_id
                ORDER BY artist_name, name";

        $data = $this->execute($query);

        return $data;
    }

    public function withHighestNumberOfTags()
    {
        $query = "SELECT artist.artist_name, video.name, count(DISTINCT tag.tag_id) AS count,
              video.youtube_id
              FROM tag
              JOIN tag_video ON tag_video.tag_id = tag.tag_id
              JOIN video ON video.video_id = tag_video.video_id
              LEFT JOIN artist_video ON artist_video.video_id = video.video_id
              LEFT JOIN artist ON artist.music_video_id = artist_video.music_video_id
              GROUP BY video.youtube_id
              ORDER BY `count` DESC
              LIMIT 10";

        $data = $this->execute($query);

        return $data;
    }

    public function lastAdded()
    {
        $query = "SELECT video.youtube_id,
                artist.artist_name, video.name
                FROM video
                LEFT JOIN artist_video ON artist_video.video_id = video.video_id
                LEFT JOIN artist ON artist.music_video_id = artist_video.music_video_id
                ORDER BY video.create_time DESC
                LIMIT 10";

        $data = $this->execute($query);

        return $data;
    }

}
