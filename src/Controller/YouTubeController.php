<?php

declare(strict_types=1);

namespace Controller;

use Controller\Base\BaseController;
use Service\YouTubeService;

class YouTubeController extends BaseController
{
    /**
     * @var YouTubeService
     */
    private $youtube;

    public function __construct()
    {
        $this->youtube = new YouTubeService();
    }

    public function get_artist_and_title(string $id)
    {
        return $this->youtube->get_artist_and_title($id);
    }
}