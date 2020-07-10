<?php

namespace Tests\Normalizer;


use Normalizer\TagListWithChildren;
use PHPUnit\Framework\TestCase;
use Repository\Base\Database;
use Repository\TagRepository;

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

        $input_with_children_field = $this->normalizer->add_children_field($input);
        $input_slug_as_key = $this->normalizer->set_slug_as_key($input_with_children_field);
        $input_with_relations = $this->normalizer->set_relations($input_slug_as_key);

        $expected = ['sport' =>
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

        $this->assertEquals($expected, $input_with_relations);
    }


    /**
     * @test
     */
    public function nested_parents()
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
