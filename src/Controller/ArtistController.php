<?php

declare(strict_types=1);

namespace Controller;

use Controller\Base\BaseController;
use Repository\ArtistRepository;

class ArtistController extends BaseController
{
    private $artistRepository;

    public function __construct()
    {
        $this->artistRepository = new ArtistRepository();
    }

    public function list()
    {
        $artists = $this->artistRepository->findAll();

        $this->response($artists);
    }
}