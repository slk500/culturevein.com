<?php

declare(strict_types=1);

use Database\TagCommand;
use Database\TagVideoCommand;
use Deleter\VideoTagDeleter;
use Deleter\VideoTagTimeDeleter;
use Factory\VideoFactory;
use Factory\TagVideoFactory;
use Database\Archiver\ArchiverRepository;
use Database\ArtistRepository;
use Database\Base\Database;
use Database\History\VideoTagHistoryRepository;
use Database\History\VideoTagTimeHistoryRepository;
use Database\SubscribeRepository;
use Database\TagRepository;
use Database\UserRepository;
use Database\VideoRepository;
use Database\TagVideoRepository;
use Database\TagVideoTimeRepository;

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
        VideoTagDeleter::class => [TagVideoCommand::class, ArchiverRepository::class],
        TagVideoFactory::class => [TagRepository::class, TagCommand::class, TagVideoCommand::class],
        VideoTagHistoryRepository::class => [Database::class],
        TagVideoRepository::class => [Database::class],
        VideoTagTimeDeleter::class => [TagVideoTimeRepository::class, ArchiverRepository::class],
        VideoTagTimeHistoryRepository::class => [Database::class],
        TagVideoTimeRepository::class => [Database::class],
        TagCommand::class => [Database::class],
        TagVideoCommand::class => [Database::class]
];
