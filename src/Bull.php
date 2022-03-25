<?php

namespace Pkg;

class Bull
{
    const VERSION = '22.3.24';

    public static function builder($var_array = null)
    {
        $predefined_vars = array(
            'returns' => null,
            'type' => null,
        );

        if (!is_array($var_array)) {
            return $predefined_vars;
        }

        $arr = array_merge($predefined_vars, $var_array);
        return $arr;
    }
}
