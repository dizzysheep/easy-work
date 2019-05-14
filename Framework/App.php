<?php

namespace Framework;

use Closure;

class App
{
    public $rootPath;
    public $runningMode;

    protected $handleList = [];

    /**
     * @desc 请求空数组
     * @var array
     */
    protected $responseData = [];

    /**
     * @var \Framework\Container|null
     */
    public static $container;

    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        $this->rootPath = dirname(__DIR__);
        $this->runningMode = getenv('EASY_MODE');

        //服务容器
        self::$container = new Container();
    }

    /**
     * 魔法函数__get
     *
     * @param  string $name  属性名称
     * @return mixed
     */
    public function __get($name = '')
    {
        return $this->$name;
    }

    /**
     * 魔法函数__set
     *
     * @param  string $name   属性名称
     * @param  mixed  $value  属性值
     * @return mixed
     */
    public function __set($name = '', $value = '')
    {
        $this->$name = $value;
    }


    /**
     * @desc 注册应用服务程序
     * @param Closure $closure
     */
    public function load(Closure $closure)
    {
        $this->handleList[] = $closure;
    }

    /**
     * @desc 注册服务
     * @param Closure $request
     */
    public function run(Closure $request)
    {
        App::$container->set('request', $request);
        foreach ($this->handleList as $handle) {
            $handle()->register($this);
        }
    }

    /**
     * @desc 页面返回结果处理
     * @param Closure $closure
     */
    public function response(Closure $closure)
    {
        register_shutdown_function([$this, 'responseShutdownFun'], $closure);
    }

    /**
     * @desc 脚本结束执行
     * @param Closure $closure
     * @var Closure $closure \Framework\Response|null
     * @throws Exceptions\CoreHttpException
     */
    public function responseShutdownFun(Closure $closure)
    {
        $useRest = App::$container->getSingle('config')->config['rest_response'];
        if ($useRest) {
            $closure()->restSuccess($this->responseData);
        }

        $closure()->response($this->responseData);
    }
}
