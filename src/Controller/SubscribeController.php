<?php

declare(strict_types=1);

namespace Controller;

use Container;
use Controller\Base\BaseController;
use Repository\SubscribeRepository;

class SubscribeController extends BaseController
{
    private Container $container;

    private SubscribeRepository $subscribe_repository;

    public function __construct()
    {
        $this->container = new Container();
        $this->subscribe_repository = $this->container->get(SubscribeRepository::class);
    }

    public function is_tag_subscribed_by_user(string $tag_slug_id)
    {
        return $this->subscribe_repository->is_tag_subscribed_by_user($tag_slug_id, $this->user_id);
    }

    public function subscribe_tag(\stdClass $data, string $tag_slug_id)
    {
        $this->subscribe_repository->subscribe_tag($tag_slug_id, $this->user_id);
    }

    public function unsubscribe_tag(string $tag_slug_id)
    {
        $this->subscribe_repository->unsubscribe_tag($tag_slug_id, $this->user_id);
    }
}
