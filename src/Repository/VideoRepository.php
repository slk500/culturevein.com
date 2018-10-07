<?php

namespace Repository;

use DateInterval;
use DateTime;

final class VideoRepository
{
    /**
     * @var ArtistRepository
     */
    private $artistRepository;

    /**
     * @var Database
     */
    private $database;

    public function __construct()
    {
        $this->artistRepository = new ArtistRepository();
        $this->database = new Database();
    }

    public function create(object $data): int
    {
        $duration = $this->getYoutubeDuration($data->youtube_id);

        $stmt = $this->database->mysqli->prepare("INSERT INTO video (youtube_id, name, release_date, duration) VALUES (?,?,?,?)");
        $stmt->bind_param("sssi", $data->youtube_id, $data->name, $data->release_date, $duration);
        $stmt->execute();

        $video_id = $this->database->mysqli->insert_id;

        $this->assignToArtist();

        return $video_id;
    }

    public function assignToArtist(int $music_video_id, int $video_id)
    {
        $stmt = $this->database->mysqli->prepare("INSERT INTO music_video_video (music_video_id,video_id) VALUES (?,?)");
        $stmt->bind_param("ii", $music_video_id, $video_id);
        $stmt->execute();
    }

    public function getYoutubeDuration(string $id)
    {
        $json = json_decode(
            file_get_contents('https://www.googleapis.com/youtube/v3/videos' .
                '?part=contentDetails&id=' . $id . '&key=' . getenv('YT_API_KEY')));

        $start = new DateTime('@0');
        $youtube = new DateTime('@0');
        $youtube->add(new DateInterval($json->items[0]->contentDetails->duration));

        return $youtube->getTimestamp() - $start->getTimestamp();
    }

    public function find(string $youTubeId)
    {
        $stmt = $this->database->mysqli->prepare( "SELECT video.name, video.release_date,video.
            youtube_id, video.duration, artist.name
            FROM video
            LEFT JOIN artist_video USING (video_id)
            LEFT JOIN artist USING (artist_id)
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
        $query = "SELECT youtube_id, artist.name, video.name
                FROM video
                LEFT JOIN artist_video USING (video_id)
                LEFT JOIN artist USING (artist_id)
                ORDER BY name, name";

        $data = $this->database->fetch($query);

        return $data;
    }

    public function withHighestNumberOfTags()
    {
        $query = "SELECT artist.name, video.name, count(DISTINCT tag.tag_id) AS count,
              video.youtube_id
              FROM tag
              JOIN tag_video USING (tag_id)
              JOIN video USING (video_id)
              LEFT JOIN artist_video USING (video_id)
              LEFT JOIN artist USING (artist_id)
              GROUP BY video.youtube_id
              ORDER BY `count` DESC
              LIMIT 10";

        $data = $this->database->fetch($query);

        return $data;
    }

    public function lastAdded()
    {
        $query = "SELECT video.youtube_id,
                artist.name, video.name
                FROM video
                LEFT JOIN artist_video USING (video_id)
                LEFT JOIN artist USING (artist_id)
                ORDER BY video.create_time DESC
                LIMIT 10";

        $data = $this->database->fetch($query);

        return $data;
    }
}
