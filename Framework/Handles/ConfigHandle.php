<?php

namespace Framework\Handles;

use Framework\App;

class ConfigHandle
{
    public $config;

    /**
     * @desc 配置文件路径
     * @var
     */
    protected $configDir;

    public function register()
    {
        //引入全局函数
        require(ROOT_PATH . DIRECTORY_SEPARATOR . "Framework" . DIRECTORY_SEPARATOR . "Helper.php");
        $this->configDir = ROOT_PATH . DIRECTORY_SEPARATOR  . "config" . DIRECTORY_SEPARATOR;
        $this->loadConfig();

        //注入容器
        App::$container->setSingle('config', $this);
    }

    /**
     * @desc 加载配置文件
     */
    public function loadConfig()
    {
        $common = (array)require($this->configDir . "common.php");
        $database = (array)require($this->configDir . "database.php");

        $config = array_merge($common, $database);

        $moduleList = $config['module'];
        foreach ($moduleList as $module) {
            if (file_exists(ROOT_PATH . "/app/config/" . $module . "/config.php")) {
                $modelConfig = (array)require(ROOT_PATH . "/app/config/" . $module . "/config.php");
                $config = array_merge($config, $modelConfig);
            }
        }

        $this->config = $config;
    }

}