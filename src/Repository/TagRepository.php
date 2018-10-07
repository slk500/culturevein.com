<?php

namespace Repository;

use Cocur\Slugify\Slugify;

class TagRepository extends Database
{
    public function findId(object $data)
    {
        $stmt = $this->mysqli->prepare("SELECT tag_id FROM tag WHERE name = ?");
        $stmt->bind_param("s", $data->name);
        $stmt->execute();
        $stmt->bind_result($tag_id);

        return $stmt->get_result()
            ->fetch_object()
            ->tag_id;
    }

    public function findAll():?array
    {
        $query = "SELECT DISTINCT(tag.name), tag.slug, tag.tag_id as id
                  FROM tag
                  JOIN tag_video using (tag_id)
                  JOIN video using (video_id)
                        ORDER BY name";

        $data = $this->fetch($query);


        return $data;
    }

    public function findByVideo(string $youtubeId)
    {
        $stmt = $this->mysqli->prepare("SELECT tag.name,
        GROUP_CONCAT(tag_video.start,'-',tag_video.stop) as times,
        tag.slug, tvc.video_id is not null as complete
        FROM tag_video
        JOIN tag USING (tag_id)
        JOIN video USING (video_id)
        LEFT JOIN tag_video_complete tvc on tag.tag_id = tvc.tag_id and tvc.video_id = video.video_id
        WHERE video.youtube_id = ?
        GROUP BY tag.name
        ORDER BY tag.name, tag_video.start");

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
                JOIN tag_video USING (tag_id)
                JOIN video USING (video_id) 
                GROUP BY tag.name, tag.slug
                ORDER BY `count` DESC
                LIMIT 10";

        $data = $this->fetch($query);

        return $data;
    }

    public function newestTen()
    {
        $query = "SELECT video.youtube_id, tag.name, artist.artist_name, video.name AS video_name,
                tag.slug, artist.slug as artist_slug, tag_video.create_time
                FROM tag_video
                JOIN video USING (video_id) 
                JOIN tag USING (tag_id)
                LEFT JOIN artist_video USING (video_id)
                LEFT JOIN artist USING (music_video_id) 
                ORDER BY tag_video.create_time DESC
                LIMIT 10";


        $data = $this->fetch($query);

        return $data;

    }

    public function find(string $slug)
    {

        $stmt = $this->mysqli->prepare("SELECT video.youtube_id, artist.artist_name, video.name as video_name,
                                        clean_time(SUM(tag_video.stop)-SUM(tag_video.start)) AS expose,
                                        tag.name, tag.slug
                                        FROM tag_video 
                                        LEFT JOIN video USING (video_id)
                                        LEFT JOIN tag USING (tag_id)
                                        LEFT JOIN artist_video USING (video_id)
                                        LEFT JOIN artist USING (music_video_id)
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

    public function create($data)
    {
        $slug = (new Slugify())->slugify($data->name);

        $stmt = $this->mysqli->prepare("INSERT INTO tag (name, slug) VALUES (?, ?)");
        $stmt->bind_param("ss", $data->name, $slug);
        $stmt->execute();
        return $this->mysqli->insert_id;
    }
}