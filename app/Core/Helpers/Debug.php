<?php

namespace App\Core\Helpers;

class Debug
{
    protected static $startTime = 0;

    public static function init()
    {
        self::$startTime = microtime();
    }

    /**
     * @return int
     */
    public static function elapsed()
    {
        return microtime() - self::$startTime;
    }

    public static function dump($data)
    {
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
    }
}