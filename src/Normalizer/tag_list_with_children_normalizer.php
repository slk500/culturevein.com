<?php

function set_relations(array $tags, array $map): array
{
    foreach ($tags as $i => $tag) {
        if ($tag['parent_slug'] === null) {
            continue;
        }
        $map[$tag['parent_slug']]['children'][] = &$tags[$i];
    }

    $x = array_filter($map, fn($tag) => $tag['parent_slug'] === null);

    return array_values($x);
}

