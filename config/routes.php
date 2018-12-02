<?php

declare(strict_types=1);

use Controller\ArtistController;
use Controller\TagController;
use Controller\UserController;
use Controller\VideoController;
use Controller\VideoTagController;
use Controller\VideoTagTimeController;
use Controller\YouTubeController;

return  [
    ['/^\/api\/artists\/*$/', ArtistController::class, 'list', 'GET'],

    ['/^\/api\/tags\/*$/', TagController::class, 'list', 'GET'],

    ['/^\/api\/tags-top\/*$/', TagController::class, 'top_ten', 'GET'],
    ['/^\/api\/tags-new\/*$/', TagController::class, 'newest_ten', 'GET'],

    ['/^\/api\/tags\/(?<tag_slug_id>[\w-]+)\/*$/', TagController::class, 'show', 'GET'],

    ['/^\/api\/videos\/*$/', VideoController::class, 'create', 'POST'],
    ['/^\/api\/videos\/*$/', VideoController::class, 'list', 'GET'],
    ['/^\/api\/videos-tags-top\/*$/', VideoController::class, 'highest_number_of_tags', 'GET'],
    ['/^\/api\/videos-new\/*$/', VideoController::class, 'newest_ten', 'GET'],

    ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/*$/', VideoController::class, 'show', 'GET'],

    ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/tags\/*$/', VideoTagController::class, 'list', 'GET'],

    ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/tags\/(?<tag_slug_id>[\w-]+)*$/', VideoTagController::class, 'delete', 'DELETE'],

    ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/tags\/*$/', VideoTagController::class, 'create', 'POST'],

    ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/tags\/(?<tag_slug_id>[\w-]+)\/*$/', VideoTagTimeController::class, 'create', 'POST'],

    ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/tags\/(?<tag_slug_id>[\w-]+)\/(?<video_tag_time_id>\d+)\/*$/', VideoTagTimeController::class, 'delete', 'DELETE'],

    ['/^\/api\/youtube\/(?<youtube_id>[\w-]{11})\/*$/', YouTubeController::class, 'get_artist_and_title', 'GET'],

    ['/^\/api\/users\/*$/', UserController::class, 'create', 'POST'],
    ['/^\/api\/users\/login\/*$/', UserController::class, 'login', 'POST']
];

