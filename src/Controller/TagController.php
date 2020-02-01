<?php

declare(strict_types=1);

namespace Controller;

use Container;
use Controller\Base\BaseController;
use DTO\Database\DatabaseTagVideo;
use Normalizer\DatabaseTagVideoNormalizer;
use Normalizer\TagListWithChildren;
use Repository\TagRepository;

class TagController extends BaseController
{
    private TagRepository $tag_repository;

    private DatabaseTagVideoNormalizer $tag_normalizer;

    public function __construct()
    {
        $container = new Container();
        $this->tag_repository = $container->get(TagRepository::class);
        $this->tag_normalizer = new DatabaseTagVideoNormalizer();
    }

    public function list()
    {
        $tags = $this->tag_repository->find_all();

        return (new TagListWithChildren())->normalize($tags);
    }

    public function list_without_relation()
    {
        return $this->tag_repository->find_all();
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

        usort($result, function ($a, $b) {
            return $b['tags'][0]['duration'] <=> $a['tags'][0]['duration'];
        });

        return [
            'name' => $tag->name,
            'videos' => $result
        ];
    }

    public function top_ten()
    {
        return $this->tag_repository->top();

    }

    public function newest_ten()
    {
        return $this->tag_repository->newest_ten();
    }
}