<?php

declare(strict_types=1);

final class Router
{
    public const ROUTES =
        [
            ['/^\/api\/artists\/*$/', 'ArtistController', 'list', 'GET'],

            ['/^\/api\/tags\/*$/', 'TagController', 'list', 'GET'],

            ['/^\/api\/tags-top\/*$/', 'TagController', 'top_ten', 'GET'],
            ['/^\/api\/tags-new\/*$/', 'TagController', 'newest_ten', 'GET'],

            ['/^\/api\/tags\/(?<tag_slug_id>[\w-]+)\/*$/', 'TagController', 'show', 'GET'],

            ['/^\/api\/videos\/*$/', 'VideoController', 'create', 'POST'],
            ['/^\/api\/videos\/*$/', 'VideoController', 'list', 'GET'],
            ['/^\/api\/videos-tags-top\/*$/', 'VideoController', 'highest_number_of_tags', 'GET'],
            ['/^\/api\/videos-new\/*$/', 'VideoController', 'newest_ten', 'GET'],

            ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/*$/', 'VideoController', 'show', 'GET'],

            ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/tags\/*$/', 'VideoTagController', 'list', 'GET'],

            ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/tags\/(?<tag_slug_id>[\w-]+)*$/', 'VideoTagController', 'delete', 'DELETE'],

            ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/tags\/*$/', 'VideoTagController', 'create', 'POST'],

            ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/tags\/(?<tag_slug_id>[\w-]+)\/*$/', 'VideoTagTimeController', 'create', 'POST'],

            ['/^\/api\/videos\/(?<youtube_id>[\w-]{11})\/tags\/(?<tag_slug_id>[\w-]+)\/(?<video_tag_time_id>\d+)\/*$/', 'VideoTagTimeController', 'delete', 'DELETE'],

            ['/^\/api\/youtube\/(?<youtube_id>[\w-]{11})\/*$/', 'YouTubeController', 'get_artist_and_title', 'GET'],

            ['/^\/api\/users\/*$/', 'UserController', 'create', 'POST'],
            ['/^\/api\/users\/login\/*$/', 'UserController', 'login', 'POST']
        ];

    /**
     * @var string
     */
    private $param;

    /**
     * @var string
     */
    private $controller;

    /**
     * @var string
     */
    private $action;

    public function match(string $url): bool
    {
        foreach (self::ROUTES as $route) {
            if (preg_match($route[0], $url, $matches) &&
                ($route[3] === $_SERVER['REQUEST_METHOD'] || $_SERVER['REQUEST_METHOD'] == 'OPTIONS')) {

                $this->controller = $route[1];
                $this->action = $route[2];
                $this->param = $matches;

                return true;
            }
        }
        return false;
    }

    public function dispatch(string $url)
    {
        if ($this->match($url)) {
            $controllerName = 'Controller\\' . $this->controller;
            $controller = new $controllerName();
            $actionName = $this->action;

            $param1 = $this->param[1] ?? null;
            $param2 = $this->param[2] ?? null;
            $param3 = $this->param[3] ?? null;

            $controller->$actionName($param1, $param2, (int) $param3);
        }
    }
}