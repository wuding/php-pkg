<?php

namespace Pkg;

use Ext\Math;

class Glob
{
    const VERSION = 25.0202;
    const REVISION = 10;

    /*
    依赖
    */
    // 导入的配置数组
    // 计划：通过函数导入
    public static $conf = array();
    // 内存缓存服务器
    public static $mem = null;
    // 注册器容器
    public static $data = array();

    /*
    变量
    */
    // 对应方法结果
    public static $lang = null;
    public static $lng = null;

    static $timeNode = [];
    static $lastTime = null;
    static $sql = [];
    static $sql_diff_min = 100;

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
    public static function lang($locale = null, $str = null, $return = null)
    {
        $lang = $str ?: ($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? null);
        $LANG = preg_split("/,/", $lang);
        $lng = array_shift($LANG);
        // 计划：中文分简繁体
        $pos = strpos($lng, '-');
        if (false !== $pos) {
            $lng = substr($lng, 0, $pos);
        }
        if (!$lng) {
            $lng = $locale;
        }
        $lang = strtolower($lng);

        // 直接返回
        if ($return) {
            return $lang;
        }
        // 返回并更新属性
        return self::$lang = $lang;
    }

    // 导入语言配置
    public static function lng($locale = null, $directory = null, $domain = null, $available_languages = null, $check_language = null)
    {
        $lang = false !== $check_language ? self::lang($locale) : $locale;
        // 是否可用语言
        if ($available_languages && !in_array($lang, $available_languages)) {
            return $GLOBALS['_LANG'] = array();
        }
        $directory = $directory ?: '.';
        $domain = $domain ?: 'messages';
        // 包含文件
        $_LANG = @include $directory ."/$lang/LC_MESSAGES/$domain.lng";
        self::$lng = $lang;
        if (!is_array($_LANG)) {
            self::$lng = $_LANG;
            $_LANG = array();
        }
        return $GLOBALS['_LANG'] = $_LANG;
    }

    /*
    注册器容器
    */

    public static function get($key = null)
    {
        $array = self::$data;
        if (array_key_exists($key, $array)) {
            return $array[$key];
        }
        return false;
    }

    public static function set($key = null, $value = null)
    {
        return self::$data[$key] = $value;
    }

/*
日志
*/

    // 运行时间标记
    public static function time($key = null, $time = null)
    {
        $time = null === $time ? microtime(true) : $time;
        if (null === $key) {
            self::$timeNode[] = $time;
        } else {
            self::$timeNode[$key] = $time;
        }
    }

    // 运行时间差
    public static function diff($key = null, $min = 100)
    {
        $lt = self::$lastTime ?: $_SERVER['REQUEST_TIME_FLOAT'];
        self::$lastTime = $m = microtime(true);
        $diff = $m - $lt;
        $diff = Math::floors($diff * 1000, 2);
        if ($diff < $min) {
            return null;
        }
        self::time($key, $diff);
        return $diff;
    }

    public static function sql($str = null, $key = null)
    {
        if ($key) {
            self::$sql[$key] = $str;
        } else {
            self::$sql[] = $str;
        }
    }

    static function sqlDiff($str = null, $key = null, $min = null)
    {
        $min = is_null($min) ? self::$sql_diff_min : $min;
        self::diff($key, $min);
        self::sql($str, $key);
    }
}
