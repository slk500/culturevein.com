<?php

declare(strict_types=1);

namespace Factory;


use DTO\VideoCreate;
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

    //todo add transaction
    public function create(VideoCreate $video_create): void
    {
        $video_id = $this->video_repository->create($video_create->video_name, $video_create->youtube_id);

        $artist_id = $this->artist_repository->find($video_create->artist_name);

        if(!$artist_id){
            $artist_id = $this->artist_repository->create($video_create->artist_name);
        }

        $this->video_repository->assign_to_artist($artist_id, $video_id);
    }
}