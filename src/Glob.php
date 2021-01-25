<?php

namespace Pkg;

class Glob
{
    /*
    依赖
    */
    // 导入的配置数组
    public static $conf = array();
    // 内存缓存服务器
    public static $mem = null;

    /*
    配置
    */

    // 获取配置项的值
    // 计划：php\fn\conf
    public static function conf($item, $value = null, $arr = null)
    {
        $pos = strpos($item, '.');
        $arr = $arr ?: self::$conf;
        if (false !== $pos) {
            $remain = substr($item, $pos + 1);
            $itm = substr($item, 0, $pos);
            $vars = $arr[$itm] ?? [];
            return $var = self::conf($remain, $value, $vars);
        }
        return $var = $arr[$item] ?? $value;
    }

    // 第一项作为键名再次获取
    public static function cnf($item, $value = null, $val = null)
    {
        // 获取配置键名
        $var = self::conf($item, $value);
        // 获取键值
        $conf = self::conf($var, $val);
        // 获取缺省
        if (null === $conf) {
            $conf = self::conf($value);
        }
        return $conf;
    }
}
