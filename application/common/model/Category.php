<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/11
 * Time: 下午4:52
 */

namespace app\common\model;

use think\Model;

class Category extends Model {


    //获取到一级分类
    public function getFirstNormalCategories(){

        //条件
        $data = [
            'status' => ['neq', -1],
            'parent_id' => 0
        ];

        //排序属性
        $order = ['listorder'=>'desc','id'=>'desc'];

        return $this->where($data)->order($order)->paginate();
    }

}












