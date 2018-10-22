<?php

declare(strict_types=1);

namespace Controller;


use Service\YouTube;

class YouTubeController extends BaseController
{
    /**
     * @var YouTube
     */
    private $youTube;

    public function __construct()
    {
        $this->youTube = new YouTube();
    }

    public function getArtistAndTitle(string $id)
    {
        $this->response(
            $this->youTube->getArtistAndTitle($id)
        );
    }
}