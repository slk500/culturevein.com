<?php

declare(strict_types=1);

namespace Controller;

use Container;
use Controller\Base\BaseController;
use DTO\Database\DatabaseTagVideo;
use Normalizer\DatabaseTagVideoNormalizer;
use Repository\TagRepository;

class TagController extends BaseController
{
    /**
     * @var TagRepository
     */
    private $tag_repository;

    /**
     * @var DatabaseTagVideoNormalizer
     */
    private $tag_normalizer;

    public function __construct()
    {
        $container = new Container();
        $this->tag_repository = $container->get(TagRepository::class);
        $this->tag_normalizer = new DatabaseTagVideoNormalizer();
    }

    public function list()
    {
        return $this->response(
            $this->tag_repository->find_all()
        );
    }

    public function show(string $slug)
    {
        $tag = $this->tag_repository->find($slug);

        if (!$tag) {
            return $this->response_not_found('Tag: ' . $slug . ' not found');
        }

        $tagVideos = $this->tag_repository->find_videos($tag->slug_id);


        $sortedTagVideos = $this->tag_normalizer->sort_by_video_slug($tagVideos, $tag);


        $result = [];
        foreach ($sortedTagVideos as $tagVideo) {

            if(!array_key_exists('ancestors',$tagVideo)) $tagVideo['ancestors'] = [];
            if(!array_key_exists('descendants',$tagVideo)) $tagVideo['descendants'] = [];

            /**
             * @var DatabaseTagVideo
             */
            $first = $tagVideo['ancestors'][0] ?? $tagVideo['descendants'][0];

            $ancestorsTime = array_reduce($tagVideo['ancestors'], fn ($carry, $tagVideo) => $carry + $tagVideo->tag_duration, null);
            $descendantsTime = array_reduce($tagVideo['descendants'], fn ($carry, $tagVideo) => $carry + $tagVideo->tag_duration, null);
            $totalTime = $ancestorsTime + $descendantsTime;

            $totalTimeTag = ($totalTime > $first->video_duration) ? $first->video_duration : $totalTime;
            $totalTimeTag = ($totalTimeTag === 0) ? null : $totalTimeTag;

            $descendants = array_map(fn (DatabaseTagVideo $databaseTagVideo) => [
                'slug' => $databaseTagVideo->tag_slug,
                'name' => $databaseTagVideo->tag_name,
                'duration' => $databaseTagVideo->tag_duration
            ]
                , $tagVideo['descendants']);

            $result [] = [
                'slug' => $first->video_slug,
                'name' => $first->video_name,
                'duration' => $first->video_duration,
                'artist' => $first->artist_name,
                'tags' => [
                    [
                        'slug' => $tag->slug_id,
                        'name' => $tag->name,
                        'duration' => $totalTimeTag,
                        'tags' => $descendants
                    ]
                ]
            ];
        }

        return $this->response($result);
    }

    public function top_ten()
    {
        return $this->response(
            $this->tag_repository->top()
        );
    }

    public function newest_ten()
    {
        return $this->response(
            $this->tag_repository->newest_ten()
        );
    }

    public function subscribe()
    {
        $this->tag_repository->subscribe();

        return $this->response_created();
    }

    public function unsubscribe()
    {
        $this->tag_repository->usubscribe();

        return $this->response_created();
    }
}