<?php

declare(strict_types=1);

return  [
    ['/^\/api\/tags\/*$/', 'tag_list', 'GET'],
    ['/^\/api\/artists\/*$/', 'artist_list', 'GET'],
    ['/^\/api\/artists\/(?<artist_slug_id>[\w-]+)\/*$/', 'artist_show', 'GET'],

    ['/^\/api\/tags-simple\/*$/', 'tag_list_without_relation', 'GET'],
    ['/^\/api\/tags-new\/*$/', 'tag_new', 'GET'],
    ['/^\/api\/tags\/(?<tag_slug_id>[\w-]+)\/*$/', 'tag_show', 'GET'],

    ['/^\/api\/tags\/(?<tag_slug_id>[\w-]+)\/descendants\/*$/', 'tag_descendants', 'GET'],
    ['/^\/api\/tags\/(?<tag_slug_id>[\w-]+)\/ancestors\/*$/', 'tag_ancestors', 'GET'],

    ['/^\/api\/videos\/*$/', 'video_create', 'POST'],
    ['/^\/api\/videos\/*$/', 'video_list', 'GET'],

    ['/^\/api\/videos-tags\/*$/', 'tag_video_list', 'GET'],
    ['/^\/api\/videos-list-new\/*$/', 'video_list_new', 'GET'],

    ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/*$/', 'video_show', 'GET'],
    ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/tags\/*$/', 'tag_video_list_for_video', 'GET'],
    ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/tags-history\/*$/', 'tag_video_history_for_video', 'GET'],
    ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/tags\/(?<tag_slug_id>[\w-]+)*$/', 'tag_video_delete', 'DELETE'],
    ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/tags\/(?<tag_slug_id>[\w-]+)\/completed\/*$/', 'tag_video_completed', 'PATCH'],
    ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/tags\/(?<tag_slug_id>[\w-]+)\/uncompleted\/*$/', 'tag_video_uncompleted', 'PATCH'],
    ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/tags\/*$/','tag_video_create', 'POST'],
    ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/tags\/(?<tag_slug_id>[\w-]+)\/*$/', 'tag_video_time_create', 'POST'],
    ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/tags\/(?<tag_slug_id>[\w-]+)\/(?<video_tag_time_id>\d+)\/*$/', 'tag_video_time_delete', 'DELETE'],

    ['/^\/api\/subscribe\/tags\/(?<tag_slug_id>[\w-]+)\/*$/', 'tag_subscribe_create', 'POST'],
    ['/^\/api\/subscribe\/tags\/(?<tag_slug_id>[\w-]+)\/*$/', 'tag_subscribe_delete', 'DELETE'],
    ['/^\/api\/subscribe\/tags\/(?<tag_slug_id>[\w-]+)\/*$/', 'is_tag_subscribed_by_user', 'GET'],

    ['/^\/api\/users\/statistics\/*$/', 'statistic_users', 'GET'],

    ['/^\/api\/users\/*$/', 'user_create', 'POST'],
    ['/^\/api\/users\/login\/*$/', 'user_login', 'POST'],
];

