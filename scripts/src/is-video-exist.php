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

    @file_get_contents(
            "https://www.youtube.com/oembed?format=json&url=http://www.youtube.com/watch?v=$youtubeId"
    );

    $code = getHttpCode($http_response_header);

    if ($code == 404) {
        echo $code . ' ' . $youtubeId . ' ' . $name . PHP_EOL;
    }
}

function getHttpCode($http_response_header)
{
    if(is_array($http_response_header))
    {
        $parts=explode(' ',$http_response_header[0]);
        if(count($parts)>1) //HTTP/1.0 <code> <text>
            return intval($parts[1]); //Get code
    }
    return 0;
}

