<?php

namespace Tests\Normalizer;

use PHPUnit\Framework\TestCase;

class TagListWithChildrenTest extends TestCase
{
    public function test_set_slug_as_key_add_count_and_children_field()
    {
        $input = [
            [
                'tag_slug_id' => 'boxing',
                'parent_slug' => 'sport',
            ],
            [
                'tag_slug_id' => 'sport',
                'parent_slug' => null
            ]
        ];

        $result = set_slug_as_key_add_count_and_children_field($input);

        $expected = [
            'boxing' =>
                [
                    'tag_slug_id' => 'boxing',
                    'parent_slug' => 'sport',
                    'count' => 0,
                    'children' => [],
                ],
            'sport' =>
                [
                    'tag_slug_id' => 'sport',
                    'parent_slug' => null,
                    'count' => 0,
                    'children' => [],
                ],
        ];

        $this->assertEquals($expected, $result);
    }

    public function test_add_nested_children()
    {
        $children = [
            'mike-tyson' =>
                [
                    'tag_slug_id' => 'mike-tyson',
                    'parent_slug' => 'boxing'
                ]
        ];

        $tags = [
            'sport' =>
                [
                    'tag_slug_id' => 'sport',
                    'parent_slug' => null,
                    'children' =>
                        [
                            [
                                'tag_slug_id' => 'boxing',
                                'parent_slug' => 'sport',
                                'children' => []
                            ]
                        ]
                ]];

        $result = add_nested_children($children, $tags);

        $expected = ['sport' =>
            [
                'tag_slug_id' => 'sport',
                'parent_slug' => null,
                'children' =>
                    [
                        [
                            'tag_slug_id' => 'boxing',
                            'parent_slug' => 'sport',
                            "children" =>
                                [
                                    [
                                        'tag_slug_id' => 'mike-tyson',
                                        'parent_slug' => 'boxing'
                                    ]
                                ]
                        ]
                    ]
            ]];

        $this->assertEquals($expected, $result);
    }

    public function test_set_relations()
    {
        $input = [
            [
                'tag_slug_id' => 'andrew-golota',
                'parent_slug' => 'boxing',
                'children' => [],
            ],
            [
                'tag_slug_id' => 'boxing',
                'parent_slug' => 'sport',
                'children' => [],
            ],
            [
                'tag_slug_id' => 'sport',
                'parent_slug' => null,
                'children' => [],
            ],
            [
                'tag_slug_id' => 'mike-tyson',
                'parent_slug' => 'boxing',
                'children' => [],
            ]
        ];

        $result = set_relations($input);

        $expected = [
            [
                'tag_slug_id' => 'sport',
                'parent_slug' => null,
                'children' =>
                    [
                        [
                            'tag_slug_id' => 'boxing',
                            'parent_slug' => 'sport',
                            "children" =>
                                [
                                    [
                                        'tag_slug_id' => 'mike-tyson',
                                        'parent_slug' => 'boxing',
                                        "children" => []
                                    ],
                                    [
                                        'tag_slug_id' => 'andrew-golota',
                                        'parent_slug' => 'boxing',
                                        "children" => []
                                    ]
                                ]
                        ]
                    ]
            ]];

        $this->assertEquals($expected, $result);
    }
}

