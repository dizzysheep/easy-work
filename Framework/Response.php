<?php

namespace Framework;

class Response
{
    /**
     * @desc rest 成功返回
     * @param array $response
     */
    public function restSuccess($response)
    {
        if (empty($response)) {
            $response = [];
        }

        header('Content-Type:Application/json; Charset=utf-8');
        $data = [
            'code' => 200,
            'message' => 'OK',
            'result' => $response
        ];
        die(jsonEncode($data));
    }

    /**
     * @desc 普通返回格式
     * @param $data
     */
    public function response($data)
    {
        die(jsonEncode($data));
    }
}