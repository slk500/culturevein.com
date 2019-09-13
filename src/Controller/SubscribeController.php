<?php

declare(strict_types=1);

namespace Controller;

use Container;
use Controller\Base\BaseController;
use Repository\SubscribeRepository;
use Service\TokenService;

class SubscribeController extends BaseController
{
    private $user_id;

    /**
     * @var Container
     */
    private $container;

    /**
     * @var SubscribeRepository
     */
    private $subscribe_repository;

    public function __construct()
    {
        $this->container = new Container();
        $this->subscribe_repository = $this->container->get(SubscribeRepository::class);
        $token_service = new TokenService();
        $token = $this->get_bearer_token();
        $this->user_id = $token_service->decode_user_id($token);
    }

    public function is_tag_subscribed_by_user(string $tag_slug_id)
    {
        return $this->response([
            'data' => $this->subscribe_repository->is_tag_subscribed_by_user($tag_slug_id, $this->user_id)
        ]);
    }


    public function subscribe_tag(string $tag_slug_id)
    {
        $this->subscribe_repository->subscribe_tag($tag_slug_id, $this->user_id);
        return $this->response_created();
    }

    public function unsubscribe_tag(string $tag_slug_id)
    {
        $this->subscribe_repository->unsubscribe_tag($tag_slug_id, $this->user_id);
        $this->response();
    }
}

