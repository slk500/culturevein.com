<?php

declare(strict_types=1);

namespace Factory;


use Repository\ArtistRepository;
use Repository\VideoRepository;

class VideoFactory
{
    private $videoRepository;

    private $artistRepository;

    public function __construct()
    {
        $this->videoRepository = new VideoRepository();
        $this->artistRepository = new ArtistRepository();
    }

    public function create(object $data)
    {
        $videoId = $this->videoRepository->create($data);

        $artistId = $this->artistRepository->find($data->artist);

        if(!$artistId){
            $artistId = $this->artistRepository->create($data->artist);
        }

        $this->videoRepository->assignToArtist($artistId, $videoId);

        $data->artist_id = $artistId;
        $data->video_id = $videoId;

        return $data;
    }
}