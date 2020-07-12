<?php

namespace Tests\Normalizer;

use Normalizer\TagListWithChildren;
use PHPUnit\Framework\TestCase;

class TagListWithChildrenTest extends TestCase
{
    private TagListWithChildren $normalizer;

    public function setUp()
    {
        $this->normalizer = new TagListWithChildren();
    }

    public function testNormalize()
    {
        $input = [
            ['slug' => 'boxing',
                'parent_slug' => 'sport',
            ],
            ['slug' => 'sport',
                'parent_slug' => null]
        ];

        $result = $this->normalizer->normalize($input);

        $expected = [
            [
                'slug' => 'sport',
                'parent_slug' => null,
                'children' =>
                    [
                        [
                            'slug' => 'boxing',
                            'parent_slug' => 'sport',
                            "children" => []
                        ]
                    ]
            ]];

        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function add_nested_children()
    {
        $children =
            ['mike-tyson' =>
                [
                    'slug' => 'mike-tyson',
                    'parent_slug' => 'boxing'
                ]
            ];

        $tags = ['sport' =>
            [
                'slug' => 'sport',
                'parent_slug' => null,
                'children' =>
                    [
                        [
                            'slug' => 'boxing',
                            'parent_slug' => 'sport',
                            "children" => []
                        ]
                    ]
            ]];

        $result = $this->normalizer->add_nested_children($children, $tags);

        $expected = ['sport' =>
            [
                'slug' => 'sport',
                'parent_slug' => null,
                'children' =>
                    [
                        [
                            'slug' => 'boxing',
                            'parent_slug' => 'sport',
                            "children" =>
                                [
                                    [
                                        'slug' => 'mike-tyson',
                                        'parent_slug' => 'boxing'
                                    ]
                                ]
                        ]
                    ]
            ]];

        $this->assertEquals($expected, $result);
    }
}
