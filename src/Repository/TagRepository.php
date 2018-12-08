<?php

declare(strict_types=1);

namespace Repository;

use Cocur\Slugify\Slugify;
use Model\Tag;
use Repository\Base\Database;

final class TagRepository
{
    /**
     * @var Database
     */
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function find_slug_id_by_name(string $name): ?string
    {
        $stmt = $this->database->mysqli->prepare("SELECT tag_slug_id FROM tag WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->bind_result($tag_slug_id);
        $stmt->fetch();

        return $tag_slug_id;
    }

    public function find_all(): ?array
    {
        $query = "SELECT tag.name as tag_name, tag.tag_slug_id
                  FROM video_tag
                  JOIN tag USING (tag_slug_id)
                  ORDER BY tag_name";

        $data = $this->database->fetch($query);

        return $data;
    }

    public function top(): array
    {
        $query = "SELECT tag.name as tag_name, count(distinct video.video_youtube_id) AS count, tag.tag_slug_id
                FROM tag
                JOIN video_tag USING (tag_slug_id)
                JOIN video USING (video_youtube_id) 
                GROUP BY tag.name, tag.tag_slug_id
                ORDER BY `count` DESC
                LIMIT 10";

        $data = $this->database->fetch($query);

        return $data;
    }

    public function newest_ten(): array
    {
        $query = "SELECT 
                video.video_youtube_id, 
                tag.name AS tag_name, 
                artist.name AS artist_name, 
                video.name AS video_name,
                tag.tag_slug_id, 
                artist.artist_slug_id AS artist_slug
                FROM video_tag
                JOIN video USING (video_youtube_id) 
                JOIN tag USING (tag_slug_id)
                LEFT JOIN artist_video USING (video_youtube_id)
                LEFT JOIN artist USING (artist_slug_id) 
                ORDER BY tag.created_at DESC
                LIMIT 10";

        $data = $this->database->fetch($query);

        return $data;
    }

    public function find(string $slug)
    {
        $stmt = $this->database->mysqli->prepare("SELECT video.video_youtube_id, artist.name AS artist_name, video.name as video_name,
                                        clean_time(SUM(video_tag_time.stop)-SUM(video_tag_time.start)) AS expose,
                                        tag.name, tag.tag_slug_id
                                        FROM video_tag
                                        LEFT JOIN video_tag_time USING (video_tag_id)
                                        LEFT JOIN video USING (video_youtube_id)
                                        LEFT JOIN tag USING (tag_slug_id)
                                        LEFT JOIN artist_video USING (video_youtube_id)
                                        LEFT JOIN artist USING (artist_slug_id)
                                        WHERE tag.tag_slug_id = ?
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

    //todo
//    public function is_user_subscribed($userId, $slug)
//    {
//        $query = "SELECT user.user_id
//                       FROM tag_user_subscribe
//                       JOIN user USING user_id
//                       WHERE tag_id = ? AND user.user_id = ?";
//    }
//
//    public function how_many_users_are_subscribe($slug)
//    {
//        "SELECT count(tag_id) FROM tag_user_subscribe WHERE tag_id = ?";
//    }

    public function save(Tag $tag): void
    {
        $stmt = $this->database->mysqli->prepare("INSERT INTO tag (name, tag_slug_id) VALUES (?, ?)");
        $stmt->bind_param("ss", $tag->tag_name, $tag->tag_slug_id);
        $stmt->execute();
    }
}