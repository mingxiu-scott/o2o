<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/18
 * Time: 下午4:53
 */
namespace app\bis\controller;


class Location extends Base
{

    private $obj;

    public function _initialize()
    {
        $this->obj = model('BisLocation');
    }

    public function index()
    {
        $bis_id = $this->getLoginUser()->bis_id;

        $bisLocation = $this->obj->where(['status' => 1, 'bis_id' => $bis_id])->paginate();

        return $this->fetch('', [
            'bl' => $bisLocation
        ]);
    }

    public function add()
    {

        if (request()->isPost()) {
            //入库操作
            $data = input('post.');

            $bisId = $this->getLoginUser()->bis_id;


            $locationResult = \Map::getLngLat($data['address']);

            if (!$locationResult || $locationResult['result']['precise'] == 0) {
                $this->error('地理位置信息不精确,请重新填写');
            }


            $validate = validate('Branch');

            $res = $validate->scene('add')->check($data);

            if (!$res) {
                $this->error($validate->getError());
            }

            //准备分类信息,提供给Category_path字段使用
            $se_categories_string = '';
            if (!empty($data['se_category_id'])) {
                $array = $data['se_category_id'];
                $se_categories_string = ',' . implode('|', $array);
            }

            //数据库校验
            $locationData = [
                'name' => $data['name'],
                'logo' => $data['logo'],
                'address' => $data['address'],
                'tel' => $data['tel'],
                'contact' => $data['contact'],
                'xpoint' => empty($locationResult['result']['location']['lng']) ? '' : $locationResult['result']['location']['lng'],
                'ypoint' => empty($locationResult['result']['location']['lat']) ? '' : $locationResult['result']['location']['lat'],
                'bis_id' => $bisId,
                'open_time' => $data['open_time'],
                'content' => $data['content'],
                'is_main' => 0,//默认都是总店
                'api_address' => $data['address'],
                'city_id' => $data['city_id'],
                'city_path' => $data['city_id'] . ',' . $data['se_city_id'],
                'category_id' => $data['category_id'],
                'category_path' => $data['category_id'] . "," . $se_categories_string
            ];

            $res = model('BisLocation')->add($locationData);

            if (!$res) {
                $this->error('门店信息添加失败');
            } else {
                $this->success('门店信息添加成功');
            }

        } else {
            $categories = model('Category')->getAllFirstNormalCategories();

            $cities = model('City')->getNormalCitiesByParentId();

            return $this->fetch('', ['cities' => $cities, 'categories' => $categories]);
        }
    }

    public function status()
    {
        $status = input('status', 0, 'intval');
        $id = input('status', 0, 'intval');

        $res = $this->obj->save(['status' => $status], ['id' => $id]);

        if (!$res) {
            $this->error('下架失败');
        }
        $this->success('下载成功');
    }

    public function detail()
    {
        $id = input('id',0,'intval');

        $categories = model('Category')->getAllFirstNormalCategories();

        $cities = model('City')->getNormalCitiesByParentId();

        $res = $this->obj->get($id);



        $se_cities = model('city')->getNormalCitiesByParentId(intval($res['city_id']));

        //获取city_path里面的二级城市分类

        $city_path = $res['city_path'];

        $se_city_id = $this->getSeCityIdByCityPath($city_path);



        //根据id获取BisLocation信息
        $res = $this->obj->get($id);

        return $this->fetch('',[
            //这是一个店铺的完整信息,不是一组
           'locationData' =>  $res,
            'cities' => $cities,
            'categories' => $categories,
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