<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/19
 * Time: 下午2:10
 */

namespace app\bis\controller;

class Deal extends Base
{

    private $obj;

    public function _initialize()
    {
        $this->obj = model('Deal');
    }

    public function index()
    {
        $bis_id = $this->getLoginUser()->bis_id;

        $deals = $this->obj->getAllNormalDeals(intval($bis_id));

        return $this->fetch('', [
            'dealData' => $deals
        ]);
    }

    public function add()
    {
        //当前登录用户的信息
        $bis_id = $this->getLoginUser()->bis_id;


        if (request()->isPost()) {
            $data = input('post.');

            //数据校验

            $validate = validate('Deal');

            $res = $validate->scene('add')->check($data);

            if (!$res) {
                $this->error($validate->getError());
            }

            //准备分类信息,提供给Category_path字段使用
            $se_categories_string = '';

            $se_single_category_string = '';


            if (!empty($data['se_category_id'])) {
                $array = $data['se_category_id'];
                $se_single_category_string = implode('|', $array);
                $se_categories_string = "," . implode('|', $array);
            }

            //准备分店勾选了哪些分店信息的数据
            $locationIds_String = '';

            if (!empty($data['location_ids'])) {
                $locationIds_String = implode(',', $data['location_ids']);

            }

            $dealData = [
                'name' => $data['name'],
                'se_category_id' => $se_single_category_string,
                'city_id' => $data['city_id'],
                'city_path' => $data['city_id'] . "," . $data['se_city_id'],
                'category_path' => $data['category_id'] . $se_categories_string,
                'bis_id' => $bis_id,
                'location_ids' => $locationIds_String,
                'image' => $data['image'],
                'description' => $data['description'],
                'start_time' => strtotime($data['start_time']),
                'end_time' => strtotime($data['end_time']),
                'origin_price' => $data['origin_price'],
                'current_price' => $data['current_price'],
                'total_count' => $data['total_count'],
                'coupons_begin_time' => strtotime($data['coupons_begin_time']),
                'coupons_end_time' => strtotime($data['coupons_end_time']),
                'bis_account_id' => $this->getLoginUser()->id,
                'notes' => $data['notes'],
                'se_city_id' => $data['se_city_id']
            ];

            //入库操作
            $res = model('Deal')->save($dealData);

            if (!$res) {
                $this->error('添加失败');
            } else {
                $this->success('添加成功');
            }

        } else {

            $cities = model('City')->getNormalCitiesByParentId();

            $categories = model('Category')->getAllFirstNormalCategories();

            //获取当前的商户的素偶有的店铺信息

            $locations = model('BisLocation')->where(['bis_id' => $bis_id])->select();


            return $this->fetch('', [
                'citys' => $cities,
                'categorys' => $categories,
                'locations' => $locations
            ]);
        }
    }

    public function detail()
    {

        //获取id
        $id = input('id', 0, 'intval');

        //根据id获取Deal信息

        $deal = $this->obj->get($id);


        $bis_id = $this->getLoginUser()->bis_id;

        $cities = model('City')->getNormalCitiesByParentId();

        $categories = model('Category')->getAllFirstNormalCategories();

        //获取当前的商户的素偶有的店铺信息
        $locations = model('BisLocation')->where(['bis_id' => $bis_id])->select();


        $se_cities = model('city')->getNormalCitiesByParentId(intval($deal['city_id']));

//        $se_cities = db('city')->where(['parent_id'=>$deal['city_id'],'status'=>['neq',-1]])->select();
        //获取city_path里面的二级城市分类

        $city_path = $deal['city_path'];

        dump($city_path);


        $se_city_id = $this->getSeCityIdByCityPath($city_path);

        dump($se_city_id);


        return $this->fetch('', [
            'citys' => $cities,
            'categorys' => $categories,
            'locations' => $locations,
            'deal' => $deal,
            'se_cities' => $se_cities,
            'se_city_id' => $se_city_id
        ]);
    }


    public function getSeCityIdByCityPath($city_path)
    {
        if (empty($city_path)) {
            return '';
        }

        //9,18格式的
        $se_cityID = '';

        if (preg_match('/,/', $city_path)) {

            $cityArray = explode(',', $city_path);

            $se_cityID = $cityArray[1];
        }

        //根据se_cityID 获取城市信息
        return $se_cityID;
    }

}