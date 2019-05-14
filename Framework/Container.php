<?php

namespace Framework;

use Framework\Exceptions\CoreHttpException;

class Container
{
    public $instanceMap = [];

    public $classMap = [];

    /**
     * 注入一个类
     * @param string $alias
     * @param string $objectName
     * @return mixed
     */
    public function set($alias = '', $objectName = '')
    {
        $this->classMap[$alias] = $objectName;
        if (is_callable($objectName)) {
            return $objectName();
        }
        return new $objectName;
    }

    /**
     * @desc 获取类
     * @param $alias
     * @return mixed
     * @throws CoreHttpException
     */
    public function get($alias)
    {
        if(isset($this->classMap[$alias])){
            if (is_callable($this->classMap[$alias])) {
                return $this->classMap[$alias]();
            }
            return $this->classMap[$alias];
        }

        throw new CoreHttpException(
            404,
            'Class:' . $alias
        );
    }
    
    /**
     * @desc 获取容器
     * @param $name
     * @return mixed
     * @throws CoreHttpException
     */
    public function getSingle($name)
    {
        if (!isset($this->instanceMap[$name])) {
            throw new CoreHttpException(500, '容器不存在');
        }
        return $this->instanceMap[$name];
    }

    /**
     * @desc 设置容器
     * @param $name
     * @param $container
     * @return mixed
     * @throws CoreHttpException
     */
    public function setSingle($name, $container)
    {
        if (empty($name) || empty($container)) {
            throw new CoreHttpException(500, "缺少容器参数");
        }

        if (is_callable($container)) {
            if (empty($name)) {
                throw new CoreHttpException(500, "{$name} is empty");
            }

            if (array_key_exists($name, $this->instanceMap)) {
                return $this->instanceMap[$name];
            }

            $this->instanceMap[$name] = $container;
        }

        if (!is_object($container)) {
            throw new CoreHttpException(500, $container);
        }

        $this->instanceMap[$name] = $container;
    }
}