<?php

declare(strict_types=1);

namespace Controller;

use Controller\Base\BaseController;
use Repository\ArtistRepository;

class ArtistController extends BaseController
{
    private $artist_repository;

    public function __construct()
    {
        $this->artist_repository = new ArtistRepository();
    }

    public function list()
    {
        $artists = $this->artist_repository->find_all();

        $this->response($artists);
    }
}