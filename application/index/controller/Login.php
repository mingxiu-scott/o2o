<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/23
 * Time: 下午4:16
 */
namespace app\index\controller;

use think\Controller;

class Login extends Controller {
    public function login(){
        return $this->fetch();
    }
}