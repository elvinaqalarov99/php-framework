<?php

if (!function_exists('config')) {
    function config(string $config = null){
        define('CONFIG', require '../config/app.php');

        if (is_null($config)) {
            return CONFIG;
        }

        $position = strpos($config, '.');

        if ($position === false) {
            return CONFIG[$config] ?? [];
        }

        $key   = substr($config, 0, $position);
        $value = substr($config, $position + 1);

        return CONFIG[$key][$value] ?? '';
    }
}