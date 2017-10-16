<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/13
 * Time: 下午2:54
 */

namespace app\bis\controller;


use think\Controller;

class Register extends Controller
{
    public function index()
    {

        $data = input('post.');

        if (isset($data['parent_id'])){
            $cities = model('City')->getNormalCitiesByParentId($data['parent_id']);

           return $this->result($cities,1,"成功");

        }

        $cities = model('City')->getNormalCitiesByParentId();

        return $this->fetch('',['cities'=>$cities]);
    }
}