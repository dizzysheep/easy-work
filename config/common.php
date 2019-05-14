<?php

namespace App\config;

return [
    'application_folder_name' => 'app',

    /* 默认模块 */
    'module' => [
        'demo'
    ],

    /* 路由默认配置 */
    'route' => [
        // 默认模块
        'default_module' => 'Demo',
        // 默认控制器
        'default_controller' => 'index',
        // 默认操作
        'default_action' => 'index',
    ],

    /* 响应结果是否使用框架定义的rest风格 */
    'rest_response' => true,

    /* 默认时区 */
    'default_timezone' => 'Asia/Shanghai',

];
