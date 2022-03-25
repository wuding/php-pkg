<?php

namespace Pkg;

class Ram
{
    const VERSION = '22.3.24';

    public static function json($filename, $destination, $data = true, $options = null)
    {
        $optional = Bull::builder($options);
        $parameters = get_defined_vars();

        $get = $put = null;
        $pos = 0;
        if (true === $data) {
            $get = @file_get_contents($destination);
            if (false === $get) {
                $get = file_get_contents($filename);
                $pos = 2;
            } else {
                $pos = 1;
                goto __ARR__;
            }
        }

        $data = 0 === $pos ? $data : $get;
        $put = file_put_contents($destination, $data);

        __ARR__:
        $arr = array(
            'method' => __METHOD__,
            'parameters' => $parameters,
            'results' => array(
                'get' => $get,
                'put' => $put,
                'pos' => $pos,
            ),
        );
        $return_values = Fish::returnValues($arr, $optional['returns']);
        return $return_values;
    }
}
