<?php

declare(strict_types=1);

use Repository\Base\Database;

require_once('../src/Repository/Base/Database.php');

$database = new Database();
$videos = $database->fetch('SELECT * FROM video');

foreach ($videos as $video) {
    isVideoExist($video);
}

function isVideoExist(array $video)
{
    $youtubeId = $video['video_youtube_id'];
    $name = $video['name'];

    $video_url =
        @file_get_contents(
            "https://www.youtube.com/oembed?format=json&url=http://www.youtube.com/watch?v=$youtubeId"
        );

    if (!$video_url) {
        echo $youtubeId . ' ' . $name . PHP_EOL;
    }
}

