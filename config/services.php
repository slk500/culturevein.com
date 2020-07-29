<?php

declare(strict_types=1);

use Deleter\VideoTagDeleter;
use Deleter\VideoTagTimeDeleter;
use Factory\VideoFactory;
use Factory\VideoTagFactory;
use Repository\Archiver\ArchiverRepository;
use Repository\ArtistRepository;
use Repository\TagRepository;
use Repository\VideoRepository;
use Repository\VideoTagRepository;
use Repository\VideoTagTimeRepository;

return [
        VideoFactory::class => [VideoRepository::class, ArtistRepository::class],
        VideoTagDeleter::class => [VideoTagRepository::class, ArchiverRepository::class],
        VideoTagFactory::class => [TagRepository::class, VideoTagRepository::class],
        VideoTagTimeDeleter::class => [VideoTagTimeRepository::class, ArchiverRepository::class],
];
