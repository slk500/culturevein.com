<?php

namespace Repository;

class TagVideoRepository extends Database
{
    public function create(object $data)
    {
        $stmt = $this->mysqli->prepare("INSERT INTO tag_video (tag_id, video_id, start, stop) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiii", $data->tag_id,$data->video_id, $data->start, $data->stop);
        $stmt->execute();
    }
}
