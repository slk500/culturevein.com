<?php

declare(strict_types=1);

namespace Normalizer;

final class VideoTagNormalizer
{
    public function normalize(array $array)
    {
       $array['times'] = $this->convert_times($array['times']);

       return $array;
    }

    public function convert_times(string $string)
    {
        $tmps =  explode(',', $string);

        $output = [];

        foreach ($tmps as $tmp){

            $r = explode('-', $tmp);
            $output []=  [
                'start' => (int)$r[0],
                'stop' => (int)$r[1]
            ];
        }

        return $output;
    }
}