<?php

declare(strict_types=1);

use Deleter\VideoTagDeleter;
use Deleter\VideoTagTimeDeleter;
use Factory\VideoFactory;
use Factory\TagVideoFactory;
use Repository\Archiver\ArchiverRepository;
use Repository\ArtistRepository;
use Repository\Base\Database;
use Repository\History\VideoTagHistoryRepository;
use Repository\History\VideoTagTimeHistoryRepository;
use Repository\SubscribeRepository;
use Repository\TagRepository;
use Repository\UserRepository;
use Repository\VideoRepository;
use Repository\TagVideoRepository;
use Repository\TagVideoTimeRepository;

//todo remove - make autowire
return [
        ArchiverRepository::class => [Database::class],
        ArtistRepository::class => [Database::class],
        Database::class => [],
        SubscribeRepository::class => [Database::class],
        TagRepository::class => [Database::class],
        UserRepository::class => [Database::class],
        VideoFactory::class => [VideoRepository::class, ArtistRepository::class],
        VideoRepository::class => [Database::class],
        VideoTagDeleter::class => [TagVideoRepository::class, ArchiverRepository::class],
        TagVideoFactory::class => [TagRepository::class, TagVideoRepository::class],
        VideoTagHistoryRepository::class => [Database::class],
        TagVideoRepository::class => [Database::class],
        VideoTagTimeDeleter::class => [TagVideoTimeRepository::class, ArchiverRepository::class],
        VideoTagTimeHistoryRepository::class => [Database::class],
        TagVideoTimeRepository::class => [Database::class]
];
