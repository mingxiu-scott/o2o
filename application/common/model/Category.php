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

    //自动写入时间戳
    protected $autoWriteTimestamp = true;

    //获取到一级分类
    public function getFirstNormalCategories($parent_id = 0){

        //条件
        $data = [
            'status' => ['neq', -1],
            'parent_id' => $parent_id
        ];
        //排序属性
        $order = ['listorder'=>'desc','id'=>'desc'];

        return $this->where($data)->order($order)->paginate();
    }

    //获取到一级分类,不带分类
    public function getAllFirstNormalCategories($parent_id = 0){

        //条件
        $data = [
            'status' => ['neq', -1],
            'parent_id' => $parent_id
        ];

        //排序属性
        $order = ['listorder'=>'desc','id'=>'desc'];

        return $this->where($data)->order($order)->select();
    }


}

