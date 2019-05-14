<?php

namespace Framework\router;

use Framework\App;
use Framework\Exceptions\CoreHttpException;
use ReflectionClass;

class EasyRouter implements Router
{
    /**
     * @desc 模块名称
     * @var $moduleName string
     */
    private $moduleName;

    /**
     * @desc 动作名称
     * @var $actionName
     */
    private $actionName;

    /**
     * @desc 控制器名称
     * @var $controllerName
     */
    private $controllerName;

    /**
     * @desc 配置文件
     * @var $config
     */
    private $config;

    /**
     * @desc 请求类
     * @var
     */
    private $request;

    /**
     * @desc 请求uri
     * @var
     */
    private $requestUri;

    /**
     * @desc 路由策略
     * @var
     */
    private $routeStrategy = '';

    /**
     * @desc app容器
     * @var
     */
    private $app;

    /**
     * @desc 文件类名
     * @var
     */
    private $classPath;

    /**
     * 类文件执行类型.
     *
     * ececute type
     *
     * @var string
     */
    private $executeType = 'controller';

    /**
     * 路由策略映射
     *
     * the router strategy map
     *
     * @var array
     */
    private $routeStrategyMap = [
        'general' => 'Framework\Router\General',
        'pathinfo' => 'Framework\Router\PathInfo',
        'user-defined' => 'Framework\Router\Userdefined',
        'micromonomer' => 'Framework\Router\Micromonomer',
        'job' => 'Framework\Router\Job'
    ];

    /**
     * 魔法函数__get.
     *
     * @param string $name 属性名称
     *
     * @return mixed
     */
    public function __get($name = '')
    {
        return $this->$name;
    }

    /**
     * 魔法函数__set.
     *
     * @param string $name 属性名称
     * @param mixed $value 属性值
     *
     * @return mixed
     */
    public function __set($name = '', $value = '')
    {
        $this->$name = $value;
    }

    public function init(App $app)
    {
        $app::$container->set('router', $this);

        // App
        $this->app = $app;

        //设置默认配置
        $this->config = $app::$container->getSingle('config')->config;

        //获取请求类
        $this->request = $app::$container->get('request');

        $this->requestUri = $this->request->server('REQUEST_URI');

        //设置默认模块
        $this->moduleName = $this->config['route']['default_module'];

        //设置默认控制器
        $this->controllerName = $this->config['route']['default_controller'];

        // 设置默认操作
        $this->actionName = $this->config['route']['default_action'];

        //路由决策
        $this->strategyJudge();

        //路由策略
        (new $this->routeStrategyMap[$this->routeStrategy])->route($this);

        $this->makeClassPath($this);

        //自定义路由
//        if ((new $this->routeStrategyMap['user-defined'])->route($this)) {
//            return;
//        }

        // 启动路由
        $this->start();
    }

    /**
     * @desc 真正启动路由
     */
    public function start()
    {
        // 判断模块存不存在
        if (!in_array(strtolower($this->moduleName), $this->config['module'])) {
            throw new CoreHttpException(404, 'Module:' . $this->moduleName);
        }

        // 判断控制器存不存在
        if (!class_exists($this->classPath)) {
            throw new CoreHttpException(404, "{$this->executeType}:{$this->classPath}");
        }

        // 反射解析当前控制器类　
        $reflection = new ReflectionClass($this->classPath);
        if ($reflection->isAbstract() || $reflection->isInterface()) {
            throw new CoreHttpException(404, 'missing controller');
        }

        //判断是否有当前方法
        if (!$reflection->hasMethod($this->actionName)) {
            throw new CoreHttpException(404, 'Action:' . $this->actionName);
        }

        //实例化controller
        $controller = $reflection->newInstance($this->request);
        $actionName = $this->actionName;

        // 获取返回值
        $this->app->responseData = $controller->$actionName();
    }

    protected function strategyJudge()
    {
        if (!empty($this->routeStrategy)) {
            return;
        }

        // 任务路由
        if ($this->app->runningMode === 'cli' && $this->request->get('router_mode') === 'job') {
            $this->routeStrategy = 'job';
            return;
        }

        // 普通路由
        if (strpos($this->requestUri, 'index.php') || $this->app->runningMode === 'cli') {
            $this->routeStrategy = 'general';
            return;
        }
        $this->routeStrategy = 'pathinfo';
    }

    /**
     * @desc 转化模型方法
     */
    protected function makeClassPath()
    {
        // 任务类
        if ($this->routeStrategy === 'job') {
            return;
        }

        // 获取控制器类
        $controllerName = ucfirst($this->controllerName);
        $moduleName = ucfirst($this->moduleName);
        $appName = ucfirst($this->config['application_folder_name']);

        //拼装路径
        $this->classPath = "{$appName}\\{$moduleName}\\Controllers\\{$controllerName}Controller";
    }
}