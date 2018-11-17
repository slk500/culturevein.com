<?php

declare(strict_types=1);

namespace Factory;


use Cocur\Slugify\Slugify;
use DTO\VideoCreate;
use Repository\ArtistRepository;
use Repository\Base\Database;
use Repository\VideoRepository;

class VideoFactory
{
    private $video_repository;

    private $artist_repository;

    private $database;

    public function __construct()
    {
        $this->database = new Database();
        $this->video_repository = new VideoRepository();
        $this->artist_repository = new ArtistRepository();
    }

    //todo add transaction
    public function create(VideoCreate $video_create): void
    {
        $this->video_repository->create($video_create);

        $artist_slug_id = $this->artist_repository->find_slug_id_by_name($video_create->artist_name);

        if(!$artist_slug_id){
            $artist_slug_id = (new Slugify())->slugify($video_create->artist_name);
            $this->artist_repository->create(
                $video_create->artist_name,
                $artist_slug_id
            );
        }

        $this->assign_video_to_artist($artist_slug_id, $video_create->youtube_id);
    }

    public function assign_video_to_artist(string $artist_slug_id, string $video_id)
    {
        $stmt = $this->database->mysqli->prepare("INSERT INTO artist_video (artist_slug_id, video_youtube_id) VALUES (?,?)");
        $stmt->bind_param("ss", $artist_slug_id, $video_id);
        $stmt->execute();
    }
}