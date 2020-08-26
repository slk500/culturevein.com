<?php

namespace Tests\Functional;

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
    }
}
