<?php

namespace App\Demo\Controllers;


class IndexController extends BaseController
{
    /**
     * @desc
     * @return array
     */
    public function index()
    {
        $id = $this->request->get('id', 0);
        $name = $this->request->get('name');

        return ['name' => $name, 'id' => $id];
    }

    /**
     * @desc 列表数据展示
     * @return array
     */
    public function list()
    {
        $pageSize = $this->request->get("page_size");
        $pageNo = $this->request->get("page_no");

        $item = [
            ['name' => 'zhangsan', 'age' => 10],
            ['name' => 'lisi', 'age' => 20],
            ['name' => 'wangwu', 'age' => 30],
        ];

        return ['total' => 10, 'item' => $item];
    }

    public function detail()
    {

    }

}