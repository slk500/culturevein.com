<?php

namespace Controller;


use Normalizer\TagsForVideo;

class TagController extends BaseController
{
    public function createAction(array $data)
    {


    }

    public function listAction(string $query = null)
    {
        if($query){
            $tags = $this->tagRepository->findByVideo($query);
            $tags = (new TagsForVideo())->normalize($tags);
        }else{
            $tags = $this->tagRepository->findAll();
        }

        $this->response($tags);
    }

    public function showAction(string $slug)
    {
        $tag = $this->tagRepository->find($slug);

        $this->response($tag);
    }

    public function topTenAction()
    {
        $tags = $this->tagRepository->top();

        $this->response($tags);
    }

    public function lastTenAction()
    {
        $tags = $this->tagRepository->newestTen();

        $this->response($tags);
    }
}