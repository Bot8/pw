<?php
/**
 * Created by PhpStorm.
 * User: artarn
 * Date: 20.02.18
 * Time: 22:49
 */

if (!function_exists('dd')) {
    function dd()
    {
        foreach (func_get_args() as $arg) {
            \App\Core\Debug::dump($arg);
        }
        
        die();
    }
}