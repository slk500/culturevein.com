<?php

namespace Repository;

class TagRepository extends BaseRepository
{
    public function findAll()
    {
        $query = "SELECT DISTINCT(tag.name), tag.slug, tag.tag_id as id
                        FROM tag
                        JOIN tag_video ON tag_video.tag_id = tag.tag_id
                        JOIN video ON video.video_id = tag_video.video_id
                        ORDER BY name";

        $data = $this->execute($query);


        return $data;
    }

    public function findByVideo(string $youtubeId)
    {
        $stmt = $this->mysqli->prepare("SELECT tag.name,
GROUP_CONCAT(tag_video.start,'-',tag_video.stop) as times,
tag.slug, tvc.video_id is not null as complete
FROM tag_video
JOIN tag ON tag.tag_id = tag_video.tag_id
JOIN video ON video.video_id = tag_video.video_id
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
                JOIN tag_video ON tag_video.tag_id = tag.tag_id
                JOIN video ON video.video_id = tag_video.video_id
                GROUP BY tag.name, tag.slug
                ORDER BY `count` DESC
                LIMIT 10";

        $data = $this->execute($query);

        return $data;
    }

    public function newestTen()
    {
        $query = "SELECT video.youtube_id, tag.name, artist.artist_name, video.name AS video_name,
                tag.slug, artist.slug as artist_slug, tag_video.create_time
                FROM tag_video
                JOIN video ON tag_video.video_id = video.video_id
                JOIN tag ON tag_video.tag_id = tag.tag_id
                LEFT JOIN artist_video ON artist_video.video_id = video.video_id
                LEFT JOIN artist ON artist.music_video_id = artist_video.music_video_id
                ORDER BY tag_video.create_time DESC
                LIMIT 10";


        $data = $this->execute($query);

        return $data;

    }

    public function find(string $slug)
    {

        $stmt = $this->mysqli->prepare("SELECT video.youtube_id, artist.artist_name, video.name as video_name,
                                        clean_time(SUM(tag_video.stop)-SUM(tag_video.start)) AS expose,
                                        tag.name, tag.slug
                                        FROM tag_video 
                                        LEFT JOIN video ON tag_video.video_id = video.video_id
                                        LEFT JOIN tag ON tag.tag_id = tag_video.tag_id
                                        LEFT JOIN artist_video ON artist_video.video_id = video.video_id
                                        LEFT JOIN artist ON artist.music_video_id = artist_video.music_video_id
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
                       JOIN user ON user.user_id = tag_user_subscribe.user_id
                       WHERE tag_id = ? AND user.user_id = ?";
    }

    public function howManyUsersSubscribe($slug)
    {
        "SELECT count(tag_id) FROM tag_user_subscribe WHERE tag_id = ?";
    }
}