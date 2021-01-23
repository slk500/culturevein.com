<?php

function set_relations(array $tags): array
{
    $tags = array_map(fn($tag) => array_merge($tag, ['children' => []]), $tags);

    $map = [];
    foreach ($tags as $i => $tag) {
        $map[$tag['tag_slug_id']] = &$tags[$i];
    }

    foreach ($tags as $i => $tag) {
        if ($tag['parent_slug'] === null) {
            continue;
        }
        $map[$tag['parent_slug']]['children'][] = &$tags[$i];
    }

    return array_values(
        array_filter($map, fn($tag) => $tag['parent_slug'] === null));
}

