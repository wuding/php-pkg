<?php

namespace Pkg;

class Glob
{
    /*
    依赖
    */
    // 导入的配置数组
    // 计划：通过函数导入
    public static $conf = array();
    // 内存缓存服务器
    public static $mem = null;

    /*
    变量
    */
    // 对应方法结果
    public static $lang = null;
    public static $lng = null;

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

    /*
    语言
    */

    // 客户端首选语言
    public static function lang($locale = null)
    {
        $lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? null;
        $LANG = preg_split("/,/", $lang);
        $lng = array_shift($LANG);
        // 计划：中文分简繁体
        $pos = strpos($lng, '-');
        if (false !== $pos) {
            $lng = substr($lng, 0, $pos);
        }
        if (!$lng) {
            return self::$lang = $locale;
        }
        return self::$lang = strtolower($lng);
    }

    // 导入语言配置
    public static function lng($locale = null, $directory = null, $available_languages = null, $check_language = null)
    {
        $lang = false !== $check_language ? self::lang($locale) : $locale;
        // 是否可用语言
        if ($available_languages && !in_array($lang, $available_languages)) {
            return $GLOBALS['_LANG'] = array();
        }
        // 包含文件
        $_LANG = @include $directory ."/$lang.php";
        self::$lng = $lang;
        if (!is_array($_LANG)) {
            $_LANG = array();
            self::$lng = false;
        }
        return $GLOBALS['_LANG'] = $_LANG;
    }
}
