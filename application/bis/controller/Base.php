<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/18
 * Time: 下午4:01
 */


namespace app\bis\controller;

use think\Controller;

class Base extends Controller
{

    public $account;

    public function _initialize()
    {
        if (!$this->isLogin()){
            $this->redirect('login/index');
        }
    }

    public function isLogin()
    {
        $login_user = $this->getLoginUser();

        if (!$login_user) {
            return false;
        }
        return true;
    }


    public function getLoginUser()
    {

        if (!$this->account) {
            $this->account = session('loginUser', '', 'bis');
        }
        return $this->account;
    }
}