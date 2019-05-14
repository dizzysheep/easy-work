<?php

namespace App\Demo\Controllers;

use Framework\Request;

class BaseController
{
    /*
     * @desc 请求类
     * @var \Framework\Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->init();
    }

    /**
     * @desc 初始化处理
     */
    public function init()
    {
        
    }
}