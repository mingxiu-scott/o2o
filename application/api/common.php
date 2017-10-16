<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/16
 * Time: 上午9:13
 */

function show($code, $message, $data)
{
    return json([
        'code' => $code,
        'message' => $message,
        'data' => $data
    ]);
}

