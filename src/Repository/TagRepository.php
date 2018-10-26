<?php

declare(strict_types=1);

namespace Repository;

use Cocur\Slugify\Slugify;
use Repository\Base\Database;

final class TagRepository
{
    /**
     * @var Database
     */
    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function find_id_by_name(string $name)
    {
        $stmt = $this->database->mysqli->prepare("SELECT tag_id FROM tag WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->bind_result($tag_id);
        $stmt->fetch();

        return $tag_id;
    }

    public function findAll():?array
    {
        $query = "SELECT DISTINCT(tag.name), tag.slug, tag.tag_id as id
                  FROM tag
                  JOIN video_tag using (tag_id)
                  JOIN video using (video_id)
                        ORDER BY name";

        $data = $this->database->fetch($query);

        return $data;
    }

    public function findByVideo(string $youtubeId)
    {
        $stmt = $this->database->mysqli->prepare("SELECT tag.name,
        GROUP_CONCAT(video_tag.start,'-',video_tag.stop) as times,
        tag.slug, tvc.video_id is not null as complete
        FROM video_tag
        JOIN tag USING (tag_id)
        JOIN video USING (video_id)
        LEFT JOIN video_tag_complete tvc on tag.tag_id = tvc.tag_id and tvc.video_id = video.video_id
        WHERE video.youtube_id = ?
        GROUP BY tag.name
        ORDER BY tag.name, video_tag.start");

        $stmt->bind_param("s", $youtubeId);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $stmt->free_result();
        $stmt->close();

        return $data;
    }

    public function top()
    {
        $query = "SELECT tag.name, count(distinct video.video_id) AS count, tag.slug
                FROM tag
                JOIN video_tag USING (tag_id)
                JOIN video USING (video_id) 
                GROUP BY tag.name, tag.slug
                ORDER BY `count` DESC
                LIMIT 10";

        $data = $this->database->fetch($query);

        return $data;
    }

    public function newestTen()
    {
        $query = "SELECT video.youtube_id, tag.name, artist.name as artist_name, video.name AS video_name,
                tag.slug, artist.slug as artist_slug, video_tag.created_at
                FROM video_tag
                JOIN video USING (video_id) 
                JOIN tag USING (tag_id)
                LEFT JOIN artist_video USING (video_id)
                LEFT JOIN artist USING (artist_id) 
                ORDER BY video_tag.created_at DESC
                LIMIT 10";

        $data = $this->database->fetch($query);

        return $data;
    }

    public function find(string $slug)
    {

        $stmt = $this->database->mysqli->prepare("SELECT video.youtube_id, artist.name as artist_name, video.name as video_name,
                                        clean_time(SUM(video_tag.stop)-SUM(video_tag.start)) AS expose,
                                        tag.name, tag.slug
                                        FROM video_tag 
                                        LEFT JOIN video USING (video_id)
                                        LEFT JOIN tag USING (tag_id)
                                        LEFT JOIN artist_video USING (video_id)
                                        LEFT JOIN artist USING (artist_id)
                                        WHERE tag.slug = ?
                                        GROUP BY video_name
                                        ORDER BY expose DESC
                                        ");

        $stmt->bind_param("s", $slug);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $stmt->free_result();
        $stmt->close();

        return $data;
    }

    public function isUserSubscribed($userId, $slug)
    {
        $query = "SELECT user.user_id
                       FROM tag_user_subscribe
                       JOIN user USING user_id
                       WHERE tag_id = ? AND user.user_id = ?";
    }

    public function howManyUsersSubscribe($slug)
    {
        "SELECT count(tag_id) FROM tag_user_subscribe WHERE tag_id = ?";
    }

    public function create(string $tag_name): int
    {
        $slug = (new Slugify())->slugify($tag_name);

        $stmt = $this->database->mysqli->prepare("INSERT INTO tag (name, slug) VALUES (?, ?)");
        $stmt->bind_param("ss", $tag_name, $slug);
        $stmt->execute();

        return $this->database->mysqli->insert_id;
    }
}