<?php

namespace Framework\Router;

class PathInfo implements RouterInterface
{
    /**
     * @param Router $entrance
     * @var \Framework\router\EasyRouter|null
     */
    public function route(Router $entrance)
    {
        $app = $entrance->app;
        $pathInfo = $_SERVER['PATH_INFO'];
        $path = array_values(array_filter(explode("/", $pathInfo)));
        if(count($path) > 0){
            switch (count($path)) {
                case 3:
                    $entrance->moduleName = $path[0];
                    $entrance->controllerName = $path[1];
                    $entrance->actionName = $path[2];
                    break;
                case 2:
                    /**
                     * 使用默认模块
                     */
                    $entrance->controllerName = $path[0];
                    $entrance->actionName = $path[1];
                    break;
                case 1:
                    /**
                     * 使用默认模块/默认控制器
                     */
                    $entrance->actionName = $path['0'];
                    break;
            }
        }

        // CLI 模式不输出
        if (empty($actionName) && $app->runningMode === 'cli') {
            $app->notOutput = true;
        }
    }
}