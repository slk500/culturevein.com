<?php

declare(strict_types=1);

namespace Repository;

use DTO\Database\DatabaseTagFind;
use DTO\Database\DatabaseTagVideo;
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

    public function find_descendants_simple(string $slug)
    {
        $stmt = $this->database->mysqli->prepare(
            "SELECT tag_slug_id, name FROM tag 
                    WHERE parent_slug_id = ?;"
        );

        $stmt->bind_param('s', $slug);
        $stmt->execute();

        $result = $stmt->get_result();
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function find_ancestors(string $slug)
    {
        $stmt = $this->database->mysqli->prepare(
            "SELECT tag.tag_slug_id, tag.name FROM tag
                    LEFT JOIN tag tag2 ON tag.tag_slug_id = tag2.parent_slug_id 
                    WHERE tag2.tag_slug_id = ? ;"
        );

        $stmt->bind_param('s', $slug);
        $stmt->execute();

        $result = $stmt->get_result();
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
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

    public function find_id_by_slug(string $slug): ?int
    {
        $stmt = $this->database->mysqli->prepare("SELECT tag_id FROM tag WHERE tag_slug_id = ?");
        $stmt->bind_param("s", $slug);
        $stmt->execute();
        $stmt->bind_result($tag_id);
        $stmt->fetch();

        return $tag_id;
    }

    public function find_all(): ?array
    {
        $query = "SELECT 
                  tag.name AS name, 
                  tag.tag_slug_id AS slug
                  FROM tag
                  ORDER BY name";

        return $this->database->fetch($query);
    }

    public function find_all_with_parent(): ?array
    {
        $query = "SELECT 
                  tag.name AS name, 
                  tag.tag_slug_id AS slug,
                  tag.parent_slug_id AS parent_slug
                  FROM tag
                  ORDER BY name";

        return $this->database->fetch($query);
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

        return $this->database->fetch($query);
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

    public function find(string $slug): ?DatabaseTagFind
    {
        $stmt = $this->database->mysqli->prepare("SELECT name, tag_slug_id as slug_id FROM tag WHERE tag.tag_slug_id = ?");

        $stmt->bind_param('s', $slug);
        $stmt->execute();

        $result = $stmt->get_result();
        return mysqli_fetch_object($result, DatabaseTagFind::class);
    }

    public function find_videos(string $slug): array
    {
        $stmt = $this->database->mysqli->prepare("SELECT 
                                        video.video_youtube_id                              AS video_slug, 
                                        artist.name                                         AS artist_name, 
                                        SUM(video_tag_time.stop)-SUM(video_tag_time.start)  AS tag_duration,
                                        tag.name                                            AS tag_name,
                                        tag.tag_slug_id                                     AS tag_slug,                            
                                        video.duration                                      AS video_duration,
                                        video.name                                          AS video_name
                                        FROM video_tag
                                        LEFT JOIN tag USING (tag_slug_id)
                                        LEFT JOIN video_tag_time USING (video_tag_id)
                                        LEFT JOIN video USING (video_youtube_id)
                                        LEFT JOIN artist_video USING (video_youtube_id)
                                        LEFT JOIN artist USING (artist_slug_id)
                                        WHERE tag.tag_slug_id = ?
                                        OR tag.parent_slug_id = ?             
                                        GROUP BY video_youtube_id, tag_slug_id 
                                        ");

        $stmt->bind_param('ss', $slug, $slug);
        $stmt->execute();

        $result = $stmt->get_result();

        $objects = [];
        while ($obj = mysqli_fetch_object($result, DatabaseTagVideo::class)) {
            $objects[] = $obj;
        }

        return $objects;
    }

    public function find_descendants(string $slug): array
    {
        $stmt = $this->database->mysqli->prepare("SELECT video.video_youtube_id, artist.name AS artist_name,
         video.name AS video_name,
         tag.name,
         tag.tag_slug_id,
          SUM(video_tag_time.stop)-SUM(video_tag_time.start) AS expose
                      FROM tag
                      LEFT JOIN video_tag USING (tag_slug_id)
                      LEFT JOIN video_tag_time USING (video_tag_id)
                      LEFT JOIN video USING (video_youtube_id)
                      LEFT JOIN artist_video USING (video_youtube_id)
                      LEFT JOIN artist USING (artist_slug_id)
                      WHERE tag.parent_slug_id = ?
                      GROUP BY video_youtube_id, tag_slug_id 
                      ");

        $stmt->bind_param('s', $slug);
        $stmt->execute();

        $result = $stmt->get_result();

        $objects = [];
        while ($obj = mysqli_fetch_object($result, DatabaseTagVideo::class)) {
            $objects[] = $obj;
        }

        return $objects;
    }

    public function save(Tag $tag): void
    {
        $stmt = $this->database->mysqli->prepare("INSERT INTO tag (name, tag_slug_id) VALUES (?, ?)");
        $stmt->bind_param("ss", $tag->name, $tag->slug_id);
        $stmt->execute();
    }

    public function get_number_of_subscribers(string $tag_slug_id): int
    {
        $stmt = $this->database->mysqli->prepare("SELECT COUNT(*) FROM subscribe_user_tag WHERE tag_slug_id = ?");
        $stmt->bind_param("s", $tag_slug_id);
        $stmt->execute();
        $stmt->bind_result($number_of_subscribers);
        $stmt->fetch();

        return $number_of_subscribers;

    }
}