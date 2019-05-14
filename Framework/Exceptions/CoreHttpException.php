<?php

namespace Framework\Exceptions;

use Exception;

class CoreHttpException extends Exception
{
    /**
     * @desc 网站错误码
     * @var array
     */
    private $httpCode = [
        // 缺少参数或者必传参数为空
        400 => 'Bad Request',
        // 没有访问权限
        403 => 'Forbidden',
        // 访问的资源不存在
        404 => 'Not Found',
        // 代码错误
        500 => 'Internet Server Error',
        // Remote Service error
        503 => 'Service Unavailable'
    ];

    /**
     * @desc 错误码
     * @var
     */
    protected $code;

    /**
     * @desc 错误信息
     * @var mixed
     */
    protected $message;

    /**
     * @desc 初始化错误信息
     * CoreHttpException constructor.
     * @param $code
     * @param $message
     */
    public function __construct($code, $message)
    {
        $this->code = $code;
        $this->message = $message . " " . $this->httpCode[$code];
    }


    /**
     * @desc rest 风格http响应
     */
    public function response()
    {
        $data = [
            'code' => $this->code,
            'message' => $this->message,
            '__coreError' => [
                'e_code' => $this->getCode(),
                'e_message' => $this->getMessage(),
                'infomations' => [
                    'file' => $this->getFile(),
                    'line' => $this->getLine(),
                    'trace' => $this->getTrace(),
                ]
            ]
        ];

        /**
         * response
         *
         * 错误处理handle里 fatal error是通过register_shutdown_function注册的函数获取的
         * 防止fatal error时输出两会json 所以response也注册到register_shutdown_function的队列中
         *
         * TODO 这个地方要重构
         */
        register_shutdown_function(function () use ($data) {
            header('Content-Type:Application/json; Charset=utf-8');
            die(json_encode($data, JSON_UNESCAPED_UNICODE));
        });
    }

}