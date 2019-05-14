<?php

return [
    /* 主库配置 */
    'database' => [
        'dbtype' => env('database')['dbtype'],
        'dbprefix' => env('database')['dbprefix'],
        'dbname' => env('database')['dbname'],
        'dbhost' => env('database')['dbhost'],
        'username' => env('database')['username'],
        'password' => env('database')['password'],
        'slave' => explode(',', env('database')['slave'])
    ],

];