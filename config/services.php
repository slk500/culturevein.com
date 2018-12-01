<?php

declare(strict_types=1);

use Deleter\VideoTagDeleter;
use Deleter\VideoTagTimeDeleter;
use Factory\VideoFactory;
use Factory\VideoTagFactory;
use Repository\Archiver\ArchiverRepository;
use Repository\ArtistRepository;
use Repository\Base\Database;
use Repository\History\VideoTagHistoryRepository;
use Repository\History\VideoTagTimeHistoryRepository;
use Repository\TagRepository;
use Repository\UserRepository;
use Repository\VideoRepository;
use Repository\VideoTagRepository;
use Repository\VideoTagTimeRepository;

return array(
        ArchiverRepository::class => [Database::class],
        ArtistRepository::class => [Database::class],
        Database::class => [],
        TagRepository::class => [Database::class],
        UserRepository::class => [Database::class],
        VideoFactory::class => [VideoRepository::class, ArtistRepository::class],
        VideoRepository::class => [Database::class],
        VideoRepository::class => [Database::class],
        VideoTagDeleter::class => [VideoTagRepository::class, ArchiverRepository::class],
        VideoTagFactory::class => [TagRepository::class, VideoTagRepository::class],
        VideoTagHistoryRepository::class => [Database::class],
        VideoTagRepository::class => [Database::class],
        VideoTagTimeDeleter::class => [VideoTagTimeRepository::class, ArchiverRepository::class],
        VideoTagTimeHistoryRepository::class => [Database::class],
        VideoTagTimeRepository::class => [Database::class]
);
