<?php

namespace Tests\Normalizer;


use DTO\Database\DatabaseTagVideo;
use Normalizer\DatabaseTagVideoNormalizer;
use PHPUnit\Framework\TestCase;
use Tests\Builder\DatabaseTagVideo\DatabaseTagVideoBuilder;

class TagVideoNormalizerTest extends TestCase
{
    private DatabaseTagVideoNormalizer $database_tag_normalizer;

    public function setUp()
    {
        $this->database_tag_normalizer = new DatabaseTagVideoNormalizer();
    }

    /**
     * @test
     */
    public function one_tag_video()
    {
        $ancestor = (new DatabaseTagVideoBuilder())
            ->artist_name('artist 1')
            ->tag_slug('ancestor')
            ->tag_name('ancestor')
            ->tag_duration(2)
            ->video_slug('ancestor_video_slug')
            ->video_name('ancestor_video_name')
            ->video_duration(1)
            ->build();

        $result = $this->database_tag_normalizer->normalize($ancestor);

        $expected = [
            'slug' => 'ancestor_video_slug',
            'name' => 'ancestor_video_name',
            'duration' => 1,
            'artist' => 'artist 1',
            'tags' => [
                [
                    'slug' => 'ancestor',
                    'name' => 'ancestor',
                    'duration' => 2
                ]
            ]
        ];

        $this->assertEquals($expected, $result);
    }
}
