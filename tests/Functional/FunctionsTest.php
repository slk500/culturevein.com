<?php

namespace Tests\Functional;

use Deleter\VideoTagDeleter;
use DTO\VideoCreate;
use Factory\VideoFactory;
use PHPUnit\Framework\TestCase;

class FunctionsTest extends TestCase
{
    public function test_find_token()
    {
        $output = find_token('Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoxLCJleHAiOjE1OTU1OTgyNjR9.y0SaR_eM0efodzUUrJR0PV9k19LCuvp0_VH1wj8UPzg');

        $this->assertNotNull($output);
    }

    public function test_read_parameters_from_function()
    {
        $input = 'tag_video_delete';
        $output = read_parameters_from_function($input);

        $expected = [
            [
                'name' => 'video_tag_deleter',
                'type' => 'Deleter\VideoTagDeleter',
            ],
            [
                'name' => 'youtube_id',
                'type' => 'string',
            ],
            [
                'name' => 'tag_slug_id',
                'type' => 'string',
            ],
            [
                'name' => 'user_id',
                'type' => 'int',
            ]
        ];

        $this->assertEquals($expected, $output);
    }

    public function test_autowire_arguments()
    {
        $parameters = [
            [
                'name' => 'video_tag_deleter',
                'type' => 'Deleter\VideoTagDeleter',
            ],
            [
                'name' => 'youtube_id',
                'type' => 'string',
            ],
            [
                'name' => 'tag_slug_id',
                'type' => 'string',
            ],
            [
                'name' => 'user_id',
                'type' => 'int',
            ]
        ];

        $match = [
            'function_name' => 'tag_video_delete',
            'http_method' => 'GET',
            'named_arguments' => [
                'tag_slug_id' => 'police',
                'youtube_id' => 'youtube_id_value',
                'user_id' => 1
            ],
            'body' => ''
        ];

        $arguments = autowire_arguments($parameters, $match, new \Container());

        $this->assertInstanceOf(VideoTagDeleter::class, $arguments[0]);
        $this->assertEquals('youtube_id_value', $arguments[1]);
        $this->assertEquals('police', $arguments[2]);
        $this->assertEquals(1, $arguments[3]);
    }

    public function test_autowire_arguments_request_data()
    {
        $parameters = [
                [
                    'name' => 'video_factory',
                    'type' => 'Factory\VideoFactory',
                ],
                [
                    'name' => 'video_create',
                    'type' => 'DTO\VideoCreate',
                ]
            ];

        $body = new \stdClass();
        $body->artist_name = 'artist name value';
        $body->video_name = 'video name value';
        $body->youtube_id = '12345678911';
        $body->duration = 100;

        $match = [
            'function_name' => 'video_create',
            'http_method' => 'POST',
            'named_arguments' => [],
            'body' => $body
        ];

        $arguments = autowire_arguments($parameters, $match, new \Container());
        $this->assertInstanceOf(VideoFactory::class, $arguments[0]);
        $this->assertInstanceOf(VideoCreate::class, $arguments[1]);
    }
}
