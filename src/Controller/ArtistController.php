<?php

declare(strict_types=1);

namespace Controller;

use Container;
use Controller\Base\BaseController;
use Repository\ArtistRepository;

class ArtistController extends BaseController
{
    private Container $container;

    public function __construct()
    {
        $this->container = new Container();
    }

    public function list()
    {
        return $this->container->get(ArtistRepository::class)
            ->find_all();
    }
}