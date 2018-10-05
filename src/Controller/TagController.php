<?php

namespace Controller;

use Normalizer\TagsForVideo;

class TagController extends BaseController
{
    public function create(object $data)
    {
        $tagId = $this->tagRepository->findId($data);

        if (!$tagId) {
           $tagId = $this->tagRepository->create($data);
        }

        $this->response($data);
    }

    public function list()
    {
        $tags = $this->tagRepository->findAll();

        $this->response($tags);
    }

    public function listQuery(string $query)
    {
        $tags = $this->tagRepository->findByVideo($query);
        $tags = (new TagsForVideo())->normalize($tags);

        $this->response($tags);
    }

    public function show(string $slug)
    {
        $tag = $this->tagRepository->find($slug);

        $this->response($tag);
    }

    public function topTen()
    {
        $tags = $this->tagRepository->top();

        $this->response($tags);
    }

    public function lastTen()
    {
        $tags = $this->tagRepository->newestTen();

        $this->response($tags);
    }
}