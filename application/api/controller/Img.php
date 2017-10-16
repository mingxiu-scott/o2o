<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/16
 * Time: 上午10:56
 */

namespace app\api\controller;

use think\Controller;
use think\Request;

class Img extends Controller{
    public function upload(){
        $file = Request::instance()->file('file');
        $info = $file->move('upload');
        if ($info && $info->getPathname())
        {
            return show(1, 'success', '/'.$info->getPathname());
        }
        return show(0, 'failes', '');
    }
}