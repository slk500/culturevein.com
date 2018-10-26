<?php

declare(strict_types=1);

namespace Normalizer;

final class VideoTagNormalizer
{
    public function normalize(array &$array): void
    {
       $array['times'] = $this->convert_times($array['times']);
    }

    public function convert_times(string $string)
    {
        $temps =  explode(',', $string);

        $output = [];

        foreach ($temps as $tmp){

            $r = explode('-', $tmp);
            $output []=  [
                'start' => (int)$r[0],
                'stop' => (int)$r[1]
            ];
        }

        return $output;
    }
}