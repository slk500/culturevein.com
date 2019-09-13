<?php

declare(strict_types=1);

namespace Controller;

use Container;
use Controller\Base\BaseController;
use Repository\UserRepository;

class StatisticController extends BaseController
{
    /**
     * @var $user_repository UserRepository
     */
    private $user_repository;

    public function __construct()
    {
        $container = new Container();
        $this->user_repository = $container->get(UserRepository::class);
    }

    public function user()
    {
        return $this->response(
            $this->user_repository->find_statistics()
        );
    }
}