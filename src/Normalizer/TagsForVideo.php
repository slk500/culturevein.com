<?php

declare(strict_types=1);

namespace Normalizer;

class TagsForVideo
{
    public function normalize(array $array)
    {
        $result = [];

        foreach ($array as $arr){

            $times = null;
            if($arr['times']){
                $times = $this->convert($arr['times']);
            }

            $result []= ['name' => $arr['name'],
                'times' => $times,
                'slug' => $arr['slug'],
                'complete' => (bool) $arr['complete']
            ];

        }
        return $result;
    }

    public function convert(string $string)
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