<?php

namespace Pkg;

class Str
{
    const VERSION = 20.2461044;

    public static function wordSegment($str = null, $sep = null)
    {
        $sep = $sep ?: "\W+|_";
        $line = mb_split("\r\n", $str);
        $arr = [];
        #mb_regex_encoding('UTF-8');
        #mb_internal_encoding("UTF-8");
        foreach ($line as $ln) {
            $white = mb_split("\s+", $ln);
            foreach ($white as $words) {
                $words = mb_ereg_replace($sep, ' ', $words);
                $cols = mb_split("\s+", $words);
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
