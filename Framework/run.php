<?php

namespace Framework;

use Framework\Exceptions\CoreHttpException;
use Framework\Handles\ConfigHandle;
use Framework\Handles\EnvHandle;
use Framework\Handles\ExceptionHandle;
use Framework\Handles\RouterHandle;

try {
    $app = new App();

    //注册env环境变量文件
    $app->load(function () {
        return new EnvHandle();
    });

    //注册配置文件等等
    $app->load(function () {
        return new ConfigHandle();
    });

    //注册异常处理
    $app->load(function () {
        return new ExceptionHandle();
    });

    //加载路由机制
    $app->load(function () {
        return new RouterHandle();
    });

    $app->run(function () use ($app) {
        return new Request($app);
    });

    $app->response(function () {
        return new Response();
    });
} catch (CoreHttpException $exp) {
    $exp->response();
}

