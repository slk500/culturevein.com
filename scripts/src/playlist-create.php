<?php

declare(strict_types=1);

use Repository\Base\Database;
use Repository\TagRepository;

require_once('../src/Repository/Base/Database.php');
require_once('../src/Repository/Base/Repository.php');
require_once('../src/Repository/TagRepository.php');
require_once('../src/DTO/Database/DatabaseTagVideo.php');

$repository = new TagRepository(new Database());
$videos = $repository->find_videos('chess');


