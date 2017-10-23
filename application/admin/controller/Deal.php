<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/20
 * Time: 上午10:55
 */

namespace app\admin\controller;

use think\Controller;

class Deal extends Controller
{
    private $obj;

    protected function _initialize()
    {
        $this->obj = model('Deal');
    }

    public function index()
    {

        $data = input('post.');

        if (empty($data)) {
            $data = [
                'category_id' => 0,
                'city_id' => 0,
                'name' => '',
                'start_time' => '',
                'end_time' => '',
                'status'=> ''
            ];
        }
        print_r($data['status']."<br>");

        $con_data = [];

        //判断是否存在条件
        //分类
        if (!empty($data['category_id'])) {
            $con_data['category_id'] = $data['category_id'];
        }

        //城市
        if (!empty($data['city_id'])) {
            $con_data['se_city_id'] = $data['city_id'];
        }

        //时间
        if (!empty($data['start_time'])) {
            $con_data['start_time'] = [
                'gt', strtotime($data['start_time'])
            ];
        }

        if (!empty($data['end_time'])) {
            $con_data['end_time'] = [
                'lt', strtotime($data['end_time'])
            ];
        }

        if (!empty($data['start_time']) && !empty($data['end_time'])) {
            //判断开始时间和结束时间的大小
            if (strtotime($data['start_time']) > strtotime($data['end_time'])) {
                $con_data['start_time'] = [
                    'gt', strtotime($data['start_time'])
                ];

                $con_data['end_time'] = [
                    'lt', strtotime($data['end_time'])
                ];

                $temp = $data['start_time'];
                $data['start_time'] = $data['end_time'];
                $data['end_time'] = $temp;
            }
        }

        //名称
        if (!empty($data['name'])) {
            $con_data['name'] = [
                'like', ' %' . $data['name'] . '%',
            ];
        }

        if (!empty($data['status']) || $data['status'] == '0'){
            $con_data['status'] = $data['status'];
        }

        //查询
        $deals = $this->obj->getDealsByCondition($con_data);

        //分类信息:
        $categories = model('Category')->getAllFirstNormalCategories();

        $cities = model('City')->getAllSeCities();


        return $this->fetch('', [
            'deals' => $deals,
            'categories' => $categories,
            'cities' => $cities,
            'data' => $data
        ]);
    }

    public function status()
    {
        $id = input('id',0,'intval');

        $status = input('status', 0, 'intval');

        $res = $this->obj->save(['status'=>$status],['id'=>$id]);

        if (!$res){
            $this->error('状态更新失败');
        }else{
            $this->success('状态更新成功');
        }

    }

    //商户团购商品审核
    public function verify()
    {

        $data = input('post.');

        if (empty($data)) {
            $data = [
                'category_id' => 0,
                'city_id' => 0,
                'name' => '',
                'start_time' => '',
                'end_time' => '',
                'status'=> ''
            ];
        }
        print_r($data['status']."<br>");

        $con_data = [];

        //判断是否存在条件
        //分类
        if (!empty($data['category_id'])) {
            $con_data['category_id'] = $data['category_id'];
        }

        //城市
        if (!empty($data['city_id'])) {
            $con_data['se_city_id'] = $data['city_id'];
        }

        //时间
        if (!empty($data['start_time'])) {
            $con_data['start_time'] = [
                'gt', strtotime($data['start_time'])
            ];
        }

        if (!empty($data['end_time'])) {
            $con_data['end_time'] = [
                'lt', strtotime($data['end_time'])
            ];
        }

        if (!empty($data['start_time']) && !empty($data['end_time'])) {
            //判断开始时间和结束时间的大小
            if (strtotime($data['start_time']) > strtotime($data['end_time'])) {
                $con_data['start_time'] = [
                    'gt', strtotime($data['start_time'])
                ];

                $con_data['end_time'] = [
                    'lt', strtotime($data['end_time'])
                ];

                $temp = $data['start_time'];
                $data['start_time'] = $data['end_time'];
                $data['end_time'] = $temp;
            }
        }

        //名称
        if (!empty($data['name'])) {
            $con_data['name'] = [
                'like', ' %' . $data['name'] . '%',
            ];
        }

        if (!empty($data['status']) || $data['status'] == '0'){
            $con_data['status'] = $data['status'];
        }

        $con_data['status'] =[
            'in',[0]
        ];

        //查询
        $deals = $this->obj->getDealsByCondition($con_data);

        //分类信息:
        $categories = model('Category')->getAllFirstNormalCategories();

        $cities = model('City')->getAllSeCities();


        return $this->fetch('', [
            'deals' => $deals,
            'categories' => $categories,
            'cities' => $cities,
            'data' => $data
        ]);
    }

}