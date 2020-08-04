<?php

declare(strict_types=1);

use Repository\SubscribeRepository;

function is_tag_subscribed_by_user(SubscribeRepository $subscribe_repository, string $tag_slug_id, ?int $user_id)
{
    return $subscribe_repository->is_tag_subscribed_by_user($tag_slug_id, $user_id);
}

function subscribe_tag(SubscribeRepository $subscribe_repository, string $tag_slug_id, ?int $user_id)
{
    $subscribe_repository->subscribe_tag($tag_slug_id, $user_id);
}

function unsubscribe_tag(SubscribeRepository $subscribe_repository, string $tag_slug_id, ?int $user_id)
{
    $subscribe_repository->unsubscribe_tag($tag_slug_id, $user_id);
}
