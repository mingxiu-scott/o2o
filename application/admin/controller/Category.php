<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/11
 * Time: 下午4:43
 */

namespace app\admin\controller;

use think\Controller;

class Category extends Controller
{
    public function index(){

        //通过model获取分类数据

        $data = model('Category')->getFirstNormalCategories();

        return $this->fetch('',[
            'categories' => $data
        ]);
    }
}

