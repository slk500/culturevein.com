<?php

declare(strict_types=1);

namespace Service;


use DateInterval;
use DateTime;
use Symfony\Component\Dotenv\Dotenv;

final class YouTubeService
{
    public function __construct()
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__.'/../../.env');
    }

    public function getDuration(string $id)
    {
        $result = json_decode(
            file_get_contents('https://www.googleapis.com/youtube/v3/videos' .
                '?part=contentDetails&id=' . $id . '&key=' . getenv('YT_API_KEY')));

        $start = new DateTime('@0');
        $youtube = new DateTime('@0');
        $youtube->add(new DateInterval($result->items[0]->contentDetails->duration));

        return $youtube->getTimestamp() - $start->getTimestamp();
    }

    public function getArtistAndTitle(string $id): array
    {
        $result = json_decode(
            file_get_contents('https://www.googleapis.com/youtube/v3/videos?part=snippet&id=' . $id . '&key=' . getenv('YT_API_KEY')));

        $artistAndTitle =  array_map('trim',
            preg_split('/-/',
                $result->items[0]->snippet->title, -1, PREG_SPLIT_NO_EMPTY));

        $result = [
          'artist' => $artistAndTitle[0],
          'title' => $artistAndTitle[1]
        ];

        return $result;
    }
}