<?php


namespace Normalizer;


class TagListWithChildren
{
    public function normalize(array $tags): array
    {
        $input_with_childrens_field = $this->add_childrens_field($tags);
        $input_slug_as_key = $this->set_slug_as_key($input_with_childrens_field);
        $input_with_relations = $this->set_relations($input_slug_as_key);

        return array_values($input_with_relations);
    }

    public function add_childrens_field(array $array): array
    {
        return array_map(function (array $item) {
            $item['childrens'] = [];
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
                    $input[$parent]['childrens'][] = $item;
                    unset($input[$item['slug']]);
                }else{
                    $deeper[$item['slug']]= $item;
                }
            }
        }

        $tags = $this->add_nested_children($deeper, $input);


        return $tags;
    }

    public function add_nested_children(array $deepers, array $tags)
    {
        foreach ($deepers as $deep) {
            foreach ($tags as &$tag) {
                foreach ($tag['childrens'] as &$children) {
                    if ($children['slug'] === $deep['parent_slug']) {
                        $children['childrens'] [] = $deep;
                        unset($deepers[$deep['slug']]);
                    }
                }
            }
        }

        if ($deepers !== []) {
            print_r($deepers);
        }

        return $tags;
    }
}