<?php

namespace Framework;

use Framework\App;
use FameFramework\Exceptions\CoreHttpException;

/**
 * 注册加载handle
 *
 */
class Load
{
    /**
     * 类名映射
     *
     * @var array
     */
    public static $map = [];
    /**
     * 类命名空间映射
     *
     * @var array
     */
    public static $namespaceMap = [];

    /**
     * 应用启动注册.
     *
     * @param  App $app 框架实例
     * @return mixed
     */
    public static function register(App $app)
    {
        self::$namespaceMap = [
            'Framework' => $app->rootPath
        ];
        // 注册框架加载函数　不使用composer加载机制加载框架　自己实现
        spl_autoload_register(['Framework\Load', 'autoload']);
        // 引入composer自加载文件
        require($app->rootPath . '/vendor/autoload.php');
    }

    /**
     * 自加载函数
     *
     * @param  string $class 类名
     *
     * @return void
     */
    private static function autoload($class)
    {
        $classOrigin = $class;
        $classInfo = explode('\\', $class);
        $className = array_pop($classInfo);
        foreach ($classInfo as &$v) {
            $v = strtolower($v);
        }
        unset($v);
        array_push($classInfo, $className);
        $class = implode('\\', $classInfo);
        $path = self::$namespaceMap['Framework'];
        $classPath = $path . '/' . str_replace('\\', '/', $class) . '.php';
        /**
         * [tideways optimize]
         * 通过tideways分析file_exists性能消耗偏多 注释掉 文件不存在 直接底层异常
         * 此处性能提升10ms左右
         */
        self::$map[$classOrigin] = $classPath;
        require_once($classPath);
    }
}