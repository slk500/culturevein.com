<?php

namespace Benchmarks;

require_once __DIR__ . '/../src/Functional/router.php';

$start_time = microtime(TRUE);

foreach (range(0, 1000) as $x) {
    find_route(include __DIR__ . '/routes_api_tags_first.php',
        '/api/tags',
    'GET',);
}

$end_time = microtime(TRUE);

$first =  $end_time - $start_time;

$start_time = microtime(TRUE);

foreach (range(0, 1000) as $x) {
    find_route(include __DIR__ . '/routes_api_tags_last.php',
        '/api/tags',
        'GET',
    );
}

$end_time = microtime(TRUE);

$last =  $end_time - $start_time;

echo $first . PHP_EOL;
echo $last . PHP_EOL;

function pct_change($old, $new, int $precision = 2): float
{
    if ($old == 0) {
        $old++;
        $new++;
    }

    $change = (($new - $old) / $old) * 100;

    return round($change, $precision);
}

echo pct_change($first, $last);
