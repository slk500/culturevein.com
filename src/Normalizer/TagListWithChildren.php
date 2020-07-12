<?php

namespace Normalizer;

class TagListWithChildren
{
    public function normalize(array $tags): array
    {
        $compose = function (...$funcs) {
            return function ($data) use ($funcs) {
                return array_reduce(
                    $funcs,
                    fn($carry, $func) => $func($carry),
                    $data,
                );
            };
        };

        $set_slug_as_key = function ($tag) {
            $result = [];
            $result[$tag['slug']] = $tag;
            return $result;
        };

        $add_children_field = function ($array){
            return array_map(fn(array $tag) => array_merge($tag, ['children' => [] ]), $array);
        };

        $normalize = $compose(
            $set_slug_as_key,
            $add_children_field
        );

        $normalizeTags = array_map($normalize, $tags);
        $result = array_merge(...$normalizeTags);

        return $this->set_relations($result);
    }

    function set_relations(array $input)
    {
        $deeper = [];
        foreach ($input as $item) {
            if ($parent = $item['parent_slug']) {
                if (array_key_exists($parent, $input)) {
                    $input[$parent]['children'][] = $item;
                    unset($input[$item['slug']]);
                }else{
                    $deeper[$item['slug']]= $item;
                }
            }
        }
        return array_values($this->add_nested_children($deeper, $input));
    }

    function add_nested_children(array $deepers, array $tags)
    {
        foreach ($deepers as $deep) {
            foreach ($tags as &$tag) {
                foreach ($tag['children'] as &$children) {
                    if ($children['slug'] === $deep['parent_slug']) {
                        $children['children'] [] = $deep;
                        unset($deepers[$deep['slug']]);
                        unset($tags[$deep['slug']]);
                    }
                }
            }
        }

        if ($deepers !== []) {
            throw new \Exception((string)$deepers);
        }

        return $tags;
    }
}