<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/11
 * Time: 下午4:00
 */

namespace app\admin\controller;

use think\Controller;

class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }


    public function welcome()
    {
        return "欢迎来到o2o管理平台";
    }
}






