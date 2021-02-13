<?php

/**
 * https://packagist.org/packages/geoip/geoip#v1.17
 *
 */

namespace Pkg\X;

class GeoIP
{
    const VERSION = '21.2.13';

    // 运行时
    public static $addr = array();
    public static $dir = null;
    public static $gi = null;
    public static $hostname = null;

    // 初始化 IP 和数据库文件
    public function __construct($hostname = null, $path = null, $filename = null, $flags = null)
    {
        if (null !== $hostname) {
            self::$hostname = $hostname;
        }
        if (null !== $path) {
            self::$dir = $path;
        }
        self::_init($filename, $flags, $path);
    }

    // 初始化打开
    public static function _init($filename = null, $flags = null, $path = null)
    {
        $file = self::_db_file($filename, $path);
        return self::$gi = self::open($file, $flags);
    }

    // 拼接数据库文件地址
    public static function _db_file($filename = null, $path = null)
    {
        $filename = $filename ?: 'GeoIP.dat';
        $path = $path ?: self::$dir;
        return $file = $path ."/". $filename;
    }

    // 获取主机名 IP 地址
    public static function _addr($hostname = null)
    {
        $ip = self::_ip($hostname);
        if (preg_match("/^([0-9\.]+)$/", $ip, $matches)) {
            return $ip;
        }
        $key = md5($ip);
        $array = self::$addr;
        if (array_key_exists($key, $array)) {
            return $array[$key];
        }
        return self::$addr[$key] = gethostbyname($ip);
    }

    // 缺省 IP
    public static function _ip($hostname = null)
    {
        return $hostname ?: self::$hostname;
    }

    // 读写数据库目录
    public static function directory($path = null)
    {
        if (null !== $path) {
            return self::$dir = $path;
        }
        return self::$dir;
    }

    // 打开数据库文件
    public static function open($filename = null, $flags = null)
    {
        $flags = null === $flags ? GEOIP_STANDARD : $flags;
        return $gi = geoip_open($filename, $flags);
    }

    // 国家代码
    public static function countryCode($hostname = null, $gi = null)
    {
        $addr = self::_addr($hostname);
        $gi = null === $gi ? self::$gi : $gi;
        return geoip_country_code_by_addr($gi, $addr);
    }
}
