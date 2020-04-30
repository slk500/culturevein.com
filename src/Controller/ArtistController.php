<?php

declare(strict_types=1);

namespace Controller;

use Container;
use Controller\Base\BaseController;
use Repository\ArtistRepository;

final class ArtistController
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