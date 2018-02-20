<?php

namespace App\Core;

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
    public function elapsed()
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