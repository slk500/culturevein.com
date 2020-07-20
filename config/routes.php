<?php

declare(strict_types=1);

use Controller\ArtistController;
use Controller\StatisticController;
use Controller\SubscribeController;
use Controller\TagController;
use Controller\UserController;
use Controller\VideoController;
use Controller\VideoTagController;
use Controller\VideoTagDescendantController;
use Controller\VideoTagTimeController;

return  [
    ['/^\/api\/artists\/(?<artist_slug_id>[\w-]+)\/*$/', ArtistController::class, 'show', 'GET'],
    ['/^\/api\/artists\/*$/', ArtistController::class, 'list', 'GET'],

    ['/^\/api\/tags\/*$/', TagController::class, 'list', 'GET'],
    ['/^\/api\/tags-simple\/*$/', TagController::class, 'list_without_relation', 'GET'],
    ['/^\/api\/tags-top\/*$/', TagController::class, 'top_ten', 'GET'],
    ['/^\/api\/tags-new\/*$/', TagController::class, 'newest_ten', 'GET'],
    ['/^\/api\/tags\/(?<tag_slug_id>[\w-]+)\/*$/', TagController::class, 'show', 'GET'],

    ['/^\/api\/tags\/(?<tag_slug_id>[\w-]+)\/descendants\/*$/', VideoTagDescendantController::class, 'descendants', 'GET'],
    ['/^\/api\/tags\/(?<tag_slug_id>[\w-]+)\/ancestors\/*$/', VideoTagDescendantController::class, 'ancestors', 'GET'],

    ['/^\/api\/videos\/*$/', VideoController::class, 'create', 'POST'],
    ['/^\/api\/videos\/*$/', VideoController::class, 'list', 'GET'],
    ['/^\/api\/videos-tags\/*$/', VideoTagController::class, 'list', 'GET'],
    ['/^\/api\/videos-tags-top\/*$/', VideoController::class, 'highest_number_of_tags', 'GET'],
    ['/^\/api\/videos-new\/*$/', VideoController::class, 'newest_ten', 'GET'],

    ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/*$/', VideoController::class, 'show', 'GET'],

    ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/tags\/*$/', VideoTagController::class, 'list_for_video', 'GET'],

    ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/tags\/(?<tag_slug_id>[\w-]+)*$/', VideoTagController::class, 'delete', 'DELETE'],

    ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/tags\/(?<tag_slug_id>[\w-]+)*$/', VideoTagController::class, 'update', 'PATCH'],

    ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/tags\/*$/', VideoTagController::class, 'create', 'POST'],

    ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/tags\/(?<tag_slug_id>[\w-]+)\/*$/', VideoTagTimeController::class, 'create', 'POST'],

    ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/tags\/(?<tag_slug_id>[\w-]+)\/(?<video_tag_time_id>\d+)\/*$/', VideoTagTimeController::class, 'delete', 'DELETE'],

    ['/^\/api\/subscribe\/tags\/(?<tag_slug_id>[\w-]+)\/*$/', SubscribeController::class, 'subscribe_tag', 'POST'],
    ['/^\/api\/subscribe\/tags\/(?<tag_slug_id>[\w-]+)\/*$/', SubscribeController::class, 'unsubscribe_tag', 'DELETE'],
    ['/^\/api\/subscribe\/tags\/(?<tag_slug_id>[\w-]+)\/*$/', SubscribeController::class, 'is_tag_subscribed_by_user', 'GET'],
    ['/^\/api\/subscribe-number\/tags\/(?<tag_slug_id>[\w-]+)\/*$/', SubscribeController::class, 'get_number_of_subscribers', 'GET'],

    ['/^\/api\/users\/*$/', UserController::class, 'create', 'POST'],
    ['/^\/api\/users\/login\/*$/', UserController::class, 'login', 'POST'],

    ['/^\/api\/users\/statistics\/*$/', StatisticController::class, 'user', 'GET']
];

