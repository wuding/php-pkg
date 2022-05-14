<?php

define('ROOT', dirname(__DIR__, 5));

$autoload = require ROOT ."/vendor/autoload.php";

use function php\func\get;
use Pkg\Func;

$offset = get('offset', 1);
$variable = array(
    'row' => array(
        'function' => '\app\soft\src\model\view\SoftIcons::fetchRow',
        'code_str' => '',
        'param_arr' => array($offset),
    ),
    'a' => array(
        'code_str' => "\$param_arr = \$results['row']->id;",
    ),
);
$results = Func::batch($variable);
var_export($results);
exit;
