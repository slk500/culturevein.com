<?php

declare(strict_types=1);

namespace Service;


use DateInterval;
use DateTime;

final class YouTubeService
{
    private string $yt_api_key;

    public function __construct()
    {
        $parameters = include(__DIR__.'/../../config/parameters.php');
        $this->yt_api_key = $parameters['yt_api_key'];
    }

    public function get_duration(string $id)
    {
        try {
            $result = json_decode(
                file_get_contents('https://www.googleapis.com/youtube/v3/videos' .
                    '?part=contentDetails&id=' . $id . '&key=' . $this->yt_api_key));
        } catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }

        $start = new DateTime('@0');
        $youtube = new DateTime('@0');
        $youtube->add(new DateInterval($result->items[0]->contentDetails->duration));

        return $youtube->getTimestamp() - $start->getTimestamp();
    }

    public function get_artist_and_title(string $id): array
    {
        $result = json_decode(
            file_get_contents('https://www.googleapis.com/youtube/v3/videos?part=snippet&id=' . $id . '&key=' . $this->yt_api_key));

        $artistAndTitle =  array_map('trim',
            preg_split('/-/',
                $result->items[0]->snippet->title, -1, PREG_SPLIT_NO_EMPTY));

        return [
          'artist' => $artistAndTitle[0] ?? null,
          'title' => $artistAndTitle[1] ?? null
        ];

    }
}