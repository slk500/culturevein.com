<?php

declare(strict_types=1);

namespace Factory;


use Repository\ArtistRepository;
use Repository\VideoRepository;

class VideoFactory
{
    private $video_repository;

    private $artist_repository;

    public function __construct()
    {
        $this->video_repository = new VideoRepository();
        $this->artist_repository = new ArtistRepository();
    }

    public function create(object $data)
    {
        $videoId = $this->video_repository->create($data);

        $artistId = $this->artist_repository->find($data->artist);

        if(!$artistId){
            $artistId = $this->artist_repository->create($data->artist);
        }

        $this->video_repository->assign_to_artist($artistId, $videoId);

        $data->artist_id = $artistId;
        $data->video_id = $videoId;

        return $data;
    }
}