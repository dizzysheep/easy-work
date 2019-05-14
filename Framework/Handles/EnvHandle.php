<?php

namespace Framework\Handles;

use Framework\App;
use Framework\Exceptions\CoreHttpException;

class EnvHandle
{
    private $envFile = ".env";

    private $envParams = [];


    /**
     * @throws CoreHttpException
     */
    public function register()
    {
        $this->loadEnv();
        App::$container->setSingle('env', $this);
    }

    /**
     * @desc 读取某个变量的值
     * @param $var
     * @return mixed|string
     */
    public function env($var)
    {
        return $this->envParams[$var] ?? [];
    }

    /**
     * @desc 读取.env配置文件
     * @throws CoreHttpException
     */
    public function loadEnv()
    {
        if (!file_exists(ROOT_PATH . DIRECTORY_SEPARATOR . $this->envFile)) {
            throw new CoreHttpException(500, 'env file not exist');
        }

        $env = parse_ini_file(ROOT_PATH . DIRECTORY_SEPARATOR . $this->envFile, true);
        $this->envParams = array_merge($_ENV, $env);
    }
}