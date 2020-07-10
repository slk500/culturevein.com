<?php

namespace Normalizer;

//todo nice class to refactor
class TagListWithChildren
{
    public function normalize(array $tags): array
    {
        $input_with_children_field = $this->add_children_field($tags);
        $input_slug_as_key = $this->set_slug_as_key($input_with_children_field);
        $input_with_relations = $this->set_relations($input_slug_as_key);

        return array_values($input_with_relations);
    }

    public function add_children_field(array $array): array
    {
        return array_map(function (array $item) {
            $item['children'] = [];
            return $item;
        }, $array);
    }

    public function set_slug_as_key(array $input)
    {
        $result = [];
        foreach ($input as $item) {
            $result[$item['slug']] = $item;
        }

        return $result;
    }

    public function set_relations(array $input)
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

        return $this->add_nested_children($deeper, $input);
    }

    public function add_nested_children(array $deepers, array $tags)
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