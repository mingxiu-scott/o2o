<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/18
 * Time: 下午4:53
 */
namespace app\bis\controller;

use think\Controller;

class Location extends Controller {
    public function index(){
        return $this->fetch();
    }

    public function add(){
        return $this->fetch();
    }

}