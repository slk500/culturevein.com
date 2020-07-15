<?php

declare(strict_types=1);

namespace Controller;

use Container;
use Controller\Base\BaseController;
use Repository\UserRepository;

final class StatisticController extends BaseController
{
    private UserRepository $user_repository;

    public function __construct()
    {
        $container = new Container();
        $this->user_repository = $container->get(UserRepository::class);
    }

    public function user()
    {
        return $this->user_repository->find_statistics();
    }
}