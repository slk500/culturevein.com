<?php

declare(strict_types=1);

use Repository\Base\Database;
use Repository\TagRepository;

require_once '../vendor/autoload.php';
require_once 'MyClient.php';
require_once 'PlaylistRepository.php';

$client = new MyClient();
$database = new Database();
$tag_repository = new TagRepository($database);
$playlist_repository = new PlaylistRepository($database);

$tag_name = '';
$tag_slug = '';

$response = $client->create_playlist($tag_name, $tag_slug);

if ($response->getStatusCode() != 200) die;

$body = json_decode($response->getBody()->getContents());
$playlist_id = $body->id;
$playlist_repository->create_playlist($playlist_id, $tag_slug);
echo $playlist_id . PHP_EOL;

foreach ($tag_repository->find_videos($tag_slug) as $video) {
    $response = $client->add_video(
        $playlist_id,
        $video->video_slug
    );

    echo $response->getStatusCode() . PHP_EOL;
    if ($response->getStatusCode() != 200) die;
    $playlist_repository
        ->add_video_to_playlist($playlist_id, $video->video_slug);
}

