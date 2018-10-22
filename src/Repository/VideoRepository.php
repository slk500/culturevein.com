<?php

declare(strict_types=1);

namespace Repository;

use DateInterval;
use DateTime;
use Service\YouTube;

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

    /**
     * @var YouTube
     */
    private $youTube;


    public function __construct()
    {
        $this->artistRepository = new ArtistRepository();
        $this->youTube = new YouTube();
        $this->database = new Database();
    }

    public function create(object $data): int
    {
        $duration = $this->youTube->getDuration($data->youtube_id);

        $stmt = $this->database->mysqli->prepare("INSERT INTO video (youtube_id, name, release_date, duration) VALUES (?,?,?,?)");
        $stmt->bind_param("sssi", $data->youtube_id, $data->name, $data->release_date, $duration);
        $stmt->execute();

        $video_id = $this->database->mysqli->insert_id;

       // $this->assignToArtist();

        return $video_id;
    }

    public function assignToArtist(int $artist_id, int $video_id)
    {
        $stmt = $this->database->mysqli->prepare("INSERT INTO artist_video (artist_id, video_id) VALUES (?,?)");
        $stmt->bind_param("ii", $artist_id, $video_id);
        $stmt->execute();
    }

    public function find(string $youTubeId)
    {
        $stmt = $this->database->mysqli->prepare( "SELECT video.name, video.release_date,video.
            youtube_id, video.duration, artist.name as artist_name, video.video_id
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
        $query = "SELECT youtube_id, artist.name as artist_name, video.name
                FROM video
                LEFT JOIN artist_video USING (video_id)
                LEFT JOIN artist USING (artist_id)
                ORDER BY artist_name";

        $data = $this->database->fetch($query);

        return $data;
    }

    public function withHighestNumberOfTags()
    {
        $query = "SELECT artist.name as artist_name, video.name, count(DISTINCT tag.tag_id) AS count,
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

    public function newestTen()
    {
        $query = "SELECT video.youtube_id,
                artist.name as artist_name, video.name
                FROM video
                LEFT JOIN artist_video USING (video_id)
                LEFT JOIN artist USING (artist_id)
                ORDER BY video.created_at DESC
                LIMIT 10";

        $data = $this->database->fetch($query);

        return $data;
    }
}
