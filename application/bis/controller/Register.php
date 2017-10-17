<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/13
 * Time: 下午2:54
 */

namespace app\bis\controller;


use think\cache\driver\File;
use think\Controller;
use think\Request;

class Register extends Controller
{
    public function index()
    {
        $data = input('post.');

        if (isset($data['parent_id'])) {
            $cities = model('City')->getNormalCitiesByParentId($data['parent_id']);

            return $this->result($cities, 1, "成功");

        }

        $categories = model('Category')->getAllFirstNormalCategories();

        $cities = model('City')->getNormalCitiesByParentId();

        return $this->fetch('', ['cities' => $cities, 'categories' => $categories]);
    }

    public function upload()
    {

        $file = Request::instance()->file('file');
        $info = $file->move('upload');
        if ($info && $info->getPathname()) {
            return show(1, 'success', '/' . $info->getPathname());
        }
        return show(0, 'failes', '');
    }

    //处理所属分类的二级目录的获取的方法
    public function getcategories()
    {
        $parent_id = input('post.id', 0, 'intval');

        $res = model('Category')->getAllFirstNormalCategories($parent_id);

        if (!$res) {
            return $this->error('', 0, '获取二级分类失败');
        }

        $this->result($res, 1, '获取成功');
    }

    public function regist()
    {
        $data = input('post.');

        //检验商户数据
        $validateAccount = validate('BisAccount');
        $res = $validateAccount->scene('add')->check($data);

        if (!$res) {
            $this->error($validateAccount->getError());
        }

        if (model('BisAccount')->getAccountByUsername($data['username'])) {
            $this->error('该商户已经存在');
        }

        //数据校验

        $validate = validate('Bis');

        $res = $validate->scene('add')->check($data);

        if (!$res) {
            $this->error($validate->getError());
        }

        //
        $validateLocation = validate('BisLocation');

        $res = $validateLocation->scene('add')->check($data);

        if (!$res) {
            $this->error($validateLocation->getError());
        }


        $locationResult = \Map::getLngLat($data['address']);

        if (!$locationResult || $locationResult['result']['precise'] == 0) {
            $this->error('地理位置信息不精确,请重新填写');
        }

        //准备数据
        $bisData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'logo' => $data['logo'],
            'licence_logo' => $data['licence_logo'],
            'description' => $data['description'],
            'city_id' => $data['city_id'],
            'city_path' => $data['city_id'] . ',' . $data['se_city_id'],
            'bank_info' => $data['bank_info'],
            'bank_user' => $data['bank_user'],
            'faren' => $data['faren'],
            'faren_tel' => $data['faren_tel']
        ];

        //提交到数据库
        $bisId = model('Bis')->add($bisData);


        //准备分类信息,提供给Category_path字段使用
        $se_categories_string = '';
        if (!empty($data['se_category_id'])) {
            $array = $data['se_category_id'];
            $se_categories_string = implode('|', $array);
        }

        //准备bisLocation表的数据
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
            'is_main' => 1,//默认都是总店
            'api_address' => $data['address'],
            'city_id' => $data['city_id'],
            'city_path' => $data['city_id'] . ',' . $data['se_city_id'],
            'category_id' => $data['category_id'],
            'category_path' => $data['category_id'] . "," . $se_categories_string,
            'bank_info' => $data['bank_info']
        ];

        $res = model('BisLocation')->add($locationData);

        //随机生成code : 四位整数

        $data['code'] = mt_rand(1000, 10000);


        //准备商户信息
        $accountData = [
            'username' => $data['username'],
            'password' => md5($data['password'] . $data['code']),
            'code' => $data['code'],
            'bis_id' => $bisId,
            'is_main' => 1
        ];

        //商户信息存入数据库

        $res = model('BisAccount')->add($accountData);

        if (!$res) {
            $this->error('申请失败');
        }

        //发送邮件通知:
        $title = '商城入驻审核通知';

        $url = request()->domain() . url('bis/register/waiting', ['id' => $bisId]);

        $content = "你的店铺信息正在审核中,点击<a href='" . $url . "'>查看状态</a>";

        \phpmailer\Email::send($data['email'], $title, $content);

        $this->success('申请成功',url('register/waiting',[
            'id' => $bisId
        ]));
    }

    public function waiting($id)
    {
        if (empty($id)) {
            return '';
        }

        //根据id获取bis信息

        $detail = model('Bis')->get($id);

        return $this->fetch('', [
            'detail' => $detail
        ]);
    }
}