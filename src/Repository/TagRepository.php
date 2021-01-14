<?php

declare(strict_types=1);

namespace Repository;

use DTO\Database\DatabaseTagFind;
use DTO\Database\DatabaseTagVideo;
use Model\Tag;
use Repository\Base\Repository;

final class TagRepository extends Repository
{
    public function find_descendants(string $slug)
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

    public function find_all(): ?array
    {
        return $this->database->fetch("SELECT 
                  tag.name AS tag_name, 
                  tag.tag_slug_id AS tag_slug_id,
                  tag.parent_slug_id AS parent_slug
                  FROM tag
                  ORDER BY tag_name");
    }


    public function find_all_order_by_numer_of_videos(): array
    {
        return $this->database->fetch("WITH RECURSIVE
    cte_path(parent, child, level, query, tag_name)
    AS (
    SELECT parent_slug_id, tag_slug_id, 1, tag_slug_id, tag.name
    FROM tag
    UNION ALL
    SELECT
    t.parent_slug_id, t.tag_slug_id,  p.level + 1, p.query, tag_name
    FROM
    cte_path p, tag t
    WHERE t.parent_slug_id = p.child
    )
SELECT cte_path.query as tag_slug_id, tag_name, count(distinct (video_tag.video_youtube_id)) AS count
FROM
    cte_path, video_tag
WHERE video_tag.tag_slug_id = cte_path.child
AND level <= 2 and video_youtube_id is not null
GROUP BY query, tag_name
ORDER BY count desc
");
    }

    public function newest_ten(): array
    {
        return $this->database->fetch("SELECT 
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
                LIMIT 10");
    }

    public function find(string $slug): ?DatabaseTagFind
    {
        $stmt = $this->database->mysqli->prepare("SELECT name, tag_slug_id as slug_id FROM tag WHERE tag.tag_slug_id = ?");

        $stmt->bind_param('s', $slug);
        $stmt->execute();

        $result = $stmt->get_result();
        return mysqli_fetch_object($result, DatabaseTagFind::class);
    }

    public function find_videos(string $tag_slug): array
    {
        $stmt = $this->database->mysqli->prepare("
    SELECT
    video.video_youtube_id                              AS video_slug,
    SUM(video_tag_time.stop)-SUM(video_tag_time.start)  AS tag_duration,
    tag.name                                            AS tag_name,
    tag.tag_slug_id                                     AS tag_slug,
    video.duration                                      AS video_duration,
    video.name                                          AS video_name,
    artist.name                                         AS artist_name
    FROM video_tag
         LEFT JOIN tag USING (tag_slug_id)
         LEFT JOIN video_tag_time USING (video_tag_id)
         LEFT JOIN video USING (video_youtube_id)
         LEFT JOIN artist_video USING (video_youtube_id)
         LEFT JOIN artist USING (artist_slug_id)
    WHERE tag.tag_slug_id = ?
     OR tag.parent_slug_id = ?
     GROUP BY video_youtube_id, tag_slug_id, artist_name
                                        ");

        if (!$stmt) {
            throw new \Exception($this->database->mysqli->error);
        }

        $stmt->bind_param('ss', $tag_slug, $tag_slug);

        if (!$stmt->execute()) {
            throw new \Exception($stmt->error);
        }

        $result = $stmt->get_result();

        $objects = [];
        while ($obj = mysqli_fetch_object($result, DatabaseTagVideo::class)) {
            $objects[] = $obj;
        }

        return $objects;
    }

    public function add(Tag $tag): void
    {
        $stmt = $this->database->mysqli->prepare("INSERT INTO tag (name, tag_slug_id) VALUES (?, ?)");
        $stmt->bind_param("ss", $tag->name, $tag->slug_id);
        $stmt->execute();
    }
}