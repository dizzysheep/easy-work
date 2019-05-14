<?php
/**
 * 框架助手函数文件
 *
 * 提供高效便捷的框架函数
 *
 * 命名空间是空 默认是\
 */
use Framework\App;

function env($paramName = '')
{
    return App::$container->getSingle('env')->env($paramName);
}


function jsonEncode($data)
{
    return json_encode($data, JSON_UNESCAPED_UNICODE);
}

if (function_exists('dump')) {
    function dump($data)
    {
        echo "<pre>";
        print_r($data);
        die;
    }
}