<?php

declare(strict_types=1);

return  [
    ['/^\/api\/artists\/*$/', 'artist_list', 'GET'],
    ['/^\/api\/artists\/(?<artist_slug_id>[\w-]+)\/*$/', 'artist_show', 'GET'],

    ['/^\/api\/users\/statistics\/*$/', 'statistic_users', 'GET'],

    ['/^\/api\/tags\/*$/', 'tag_list', 'GET'],
    ['/^\/api\/tags-simple\/*$/', 'tag_list_without_relation', 'GET'],
    ['/^\/api\/tags-top\/*$/', 'tag_in_videos', 'GET'],
    ['/^\/api\/tags-new\/*$/', 'tag_new', 'GET'],
    ['/^\/api\/tags\/(?<tag_slug_id>[\w-]+)\/*$/', 'tag_show', 'GET'],

    ['/^\/api\/tags\/(?<tag_slug_id>[\w-]+)\/descendants\/*$/', 'tag_descendants', 'GET'],
    ['/^\/api\/tags\/(?<tag_slug_id>[\w-]+)\/ancestors\/*$/', 'tag_ancestors', 'GET'],

    ['/^\/api\/videos\/*$/', 'video_create', 'POST'],
    ['/^\/api\/videos\/*$/', 'video_list', 'GET'],

    ['/^\/api\/videos-tags\/*$/', 'video_tag_list', 'GET'],
    ['/^\/api\/videos-list-count-tags\/*$/', 'video_list_count_tags', 'GET'],
    ['/^\/api\/videos-list-new\/*$/', 'video_list_new', 'GET'],

    ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/*$/', 'video_show', 'GET'],

    ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/tags\/*$/', 'tag_video_list_for_video', 'GET'],

    ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/tags\/(?<tag_slug_id>[\w-]+)*$/', 'tag_video_delete', 'DELETE'],

    ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/tags\/(?<tag_slug_id>[\w-]+)\/completed\/*$/', 'tag_video_completed', 'PATCH'],
    ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/tags\/(?<tag_slug_id>[\w-]+)\/uncompleted\/*$/', 'tag_video_uncompleted', 'PATCH'],

    ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/tags\/*$/','tag_video_create', 'POST'],
//
//    ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/tags\/(?<tag_slug_id>[\w-]+)\/*$/', VideoTagTimeController::class, 'create', 'POST'],
//
//    ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/tags\/(?<tag_slug_id>[\w-]+)\/(?<video_tag_time_id>\d+)\/*$/', VideoTagTimeController::class, 'delete', 'DELETE'],
//
//    ['/^\/api\/subscribe\/tags\/(?<tag_slug_id>[\w-]+)\/*$/', SubscribeController::class, 'subscribe_tag', 'POST'],
//    ['/^\/api\/subscribe\/tags\/(?<tag_slug_id>[\w-]+)\/*$/', SubscribeController::class, 'unsubscribe_tag', 'DELETE'],
//    ['/^\/api\/subscribe\/tags\/(?<tag_slug_id>[\w-]+)\/*$/', SubscribeController::class, 'is_tag_subscribed_by_user', 'GET'],
//    ['/^\/api\/subscribe-number\/tags\/(?<tag_slug_id>[\w-]+)\/*$/', SubscribeController::class, 'get_number_of_subscribers', 'GET'],
//
//    ['/^\/api\/users\/*$/', UserController::class, 'create', 'POST'],
//    ['/^\/api\/users\/login\/*$/', UserController::class, 'login', 'POST'],

];

