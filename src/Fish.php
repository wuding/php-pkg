<?php

namespace Pkg;

class Fish
{
    const VERSION = '22.3.24';

    public static function returnValues($arr, $subject = null)
    {
        $items = self::returnItems($arr, $subject);
        return $items;
    }

    public static function returnItems($arr, $subject = null)
    {
        if (!is_string($subject)) {
            return $arr;
        }

        $pattern = "/,/";
        $variable = preg_split($pattern, $subject);
        $pieces = array();
        foreach ($variable as $key) {
            $pieces[$key] = $arr[$key] ?? null;
        }

        return $pieces;
    }

    public static function returnTypes()
    {

    }
}
