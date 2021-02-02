<?php

namespace Tests\Normalizer;

use PHPUnit\Framework\TestCase;

class TagListWithChildrenTest extends TestCase
{
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

