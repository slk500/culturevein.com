<?php

declare(strict_types=1);

namespace Controller;


use Service\YouTubeService;

class YouTubeController extends BaseController
{
    /**
     * @var YouTubeService
     */
    private $youTube;

    public function __construct()
    {
        $this->youTube = new YouTubeService();
    }

    public function getArtistAndTitle(string $id)
    {
        $this->response(
            $this->youTube->getArtistAndTitle($id)
        );
    }
}