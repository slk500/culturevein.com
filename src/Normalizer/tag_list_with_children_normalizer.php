<?php

function normalize_tag_list_with_relation(array $tags): array
{
    $normalize = compose(
        'add_count_field',
        'add_children_field',
        'set_slug_as_key',
    );

    $normalizeTags = array_map($normalize, $tags);
    return array_merge(...$normalizeTags);
}

function set_relations(array $input): array
{
    $deeper = [];
    foreach ($input as $item) {
        if ($parent = $item['parent_slug']) {
            if (array_key_exists($parent, $input)) {
                $input[$parent]['children'][] = $item;
                unset($input[$item['tag_slug_id']]);
            } else {
                $deeper[$item['tag_slug_id']] = $item;
            }
        }
    }
    return array_values(add_nested_children($deeper, $input));
}

function add_nested_children(array $deepers, array $tags): array
{
    foreach ($deepers as $deep) {
        foreach ($tags as &$tag) {
            foreach ($tag['children'] as &$children) {
                if ($children['tag_slug_id'] === $deep['parent_slug']) {
                    $children['children'] [] = $deep;
                    unset($deepers[$deep['tag_slug_id']]);
                    unset($tags[$deep['tag_slug_id']]);
                }
            }
        }
    }

    if ($deepers !== []) {
        throw new \Exception((string)$deepers);
    }

    return $tags;
}