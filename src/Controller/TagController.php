<?php

namespace Controller;

use Repository\TagRepository;
use Repository\VideoTagRepository;

class TagController extends BaseController
{
    private $tagRepository;

    private $videoTagRepository;

    public function __construct()
    {
        $this->tagRepository = new TagRepository();
        $this->videoTagRepository = new VideoTagRepository();
    }

    public function create(object $data)
    {
      ///  $body = file_get_contents('php://input');
//        $data = json_decode($body);
//        $controller->create($data);


        $tagId = $this->tagRepository->findId($data);

        if (!$tagId) {
           $this->tagRepository->create($data);
        }

        $data->tag_id = $tagId;

        $this->videoTagRepository->create($data);

        $this->response($data);
    }

    public function list()
    {
        $tags = $this->tagRepository->findAll();

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

    public function newestTen()
    {
        $tags = $this->tagRepository->newestTen();

        $this->response($tags);
    }
}