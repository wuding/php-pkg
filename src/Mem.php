<?php

namespace Pkg;

class Mem
{
    const VERSION = '21.2.16';

    public function __construct()
    {

    }

    public function __call($name, $arguments)
    {
        $obj = Glob::get('Mem');
        return call_user_func_array(array($obj, $name), $arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        $obj = new static();
        return call_user_func_array(array($obj, $name), $arguments);
    }
}
