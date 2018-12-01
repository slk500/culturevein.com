<?php

declare(strict_types=1);

namespace Controller;

use Container;
use Controller\Base\BaseController;
use Repository\ArtistRepository;

class ArtistController extends BaseController
{
    /**
     * @var Container
     */
    private $container;

    public function __construct()
    {
        $this->container = new Container();
    }

    public function list()
    {
        $artists = $this->container->get(ArtistRepository::class)
            ->find_all();

        $this->response($artists);
    }
}