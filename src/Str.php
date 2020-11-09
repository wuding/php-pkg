<?php

namespace Pkg;

class Str
{
    const VERSION = 20.2461044;

    public static function wordSegment($str = null)
    {
        $line = preg_split("/\r\n/", $str);
        $arr = [];
        foreach ($line as $ln) {
            $white = preg_split("/\s+/", $ln);
            foreach ($white as $words) {
                $words = preg_replace("/\W+|_/", ' ', $words);
                $cols = preg_split("/\s+/", $words);
                foreach ($cols as $word) {
                    $word = trim($word);
                    if (!$word) {
                        continue 1;
                    }

                    if (!array_key_exists($word, $arr)) {
                        $arr[$word] = 1;
                    } else {
                        $arr[$word]++;
                    }
                }
            }
        }
        return $arr;
    }
}
