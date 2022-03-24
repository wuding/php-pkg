<?php

namespace Pkg;

class Func
{
    const VERSION = '22.3.24';

    public static function batch($variable)
    {
        $results = array();
        foreach ($variable as $key => $value) {
            $keys_values = array(
                'code_str' => null,
                'function' => null,
                'param_arr' => null,
            );
            $var_array = array_merge($keys_values, $value);
            extract($var_array);
            eval($code_str);
            $results[$key] = $function ? call_user_func_array($function, $param_arr) : $param_arr;
        }
        return $results;
    }
}
