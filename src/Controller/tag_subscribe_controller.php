<?php

declare(strict_types=1);

use Database\SubscribeRepository;

//todo inconsistent in design
function is_tag_subscribed_by_user(SubscribeRepository $subscribe_repository, string $tag_slug_id, int $user_id): bool
{
    return $subscribe_repository->is_tag_subscribed_by_user($tag_slug_id, $user_id);
}

function tag_subscribe_create(SubscribeRepository $subscribe_repository, string $tag_slug_id, int $user_id): void
{
    $subscribe_repository->subscribe_tag($tag_slug_id, $user_id);
}

function tag_subscribe_delete(SubscribeRepository $subscribe_repository, string $tag_slug_id, int $user_id): void
{
    $subscribe_repository->unsubscribe_tag($tag_slug_id, $user_id);
}
