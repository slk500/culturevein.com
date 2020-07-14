<?php

declare(strict_types=1);

namespace Factory;


use Cocur\Slugify\Slugify;
use DTO\VideoCreate;
use Repository\ArtistRepository;
use Repository\VideoRepository;

class VideoFactory
{
    private $video_repository;

    private $artist_repository;

    public function __construct(VideoRepository $video_repository, ArtistRepository $artist_repository)
    {
        $this->video_repository = $video_repository;
        $this->artist_repository = $artist_repository;
    }

    //todo add transaction
    public function create(VideoCreate $video_create): void
    {
        $this->video_repository->save($video_create);

        $artist_slug_id = $this->artist_repository->find_slug_id_by_name($video_create->artist_name);

        if(!$artist_slug_id){
            $artist_slug_id = (new Slugify())->slugify($video_create->artist_name);
            $this->artist_repository->save(
                $video_create->artist_name,
                $artist_slug_id
            );
        }

        $this->artist_repository->assign_video_to_artist($artist_slug_id, $video_create->youtube_id);
    }
}