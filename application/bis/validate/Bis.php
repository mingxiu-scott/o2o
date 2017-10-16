<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/16
 * Time: 下午8:00
 */
namespace app\common\validate;

use think\Validate;

class Bis extends Validate
{

    protected $rule = [
        'name' => 'require|max:20',
        'email' => 'email',
        'logo' => 'require',
        'licence_logo' => 'require',
        'description' => 'require',
        'bank_info' => 'require',
        'bank_name' => 'require',
        'bank_user' => 'require',
        'faren' => 'require',
        'faren_tel' => 'require',
        'city_id' => 'require',
        'se_city_id' => 'require'
    ];

    protected $message = [
        'name.require' => '店名不能为空',
        'name.max' => '店名长度不能超过20',
        'email.email' => '邮箱格式错误',
        'logo.require' => '缩略图不能为空',
        'licence_logo.require' => '营业执照不能为空',
        'description.require' => '店铺描述不能为空',
        'bank_info.require' => '银行卡号不能为空',
        'bank_name.require' => '开户行不能为空',
        'bank_user.require' => '开户人姓名不能为空',
        'faren.require' => '法人姓名不能为空',
        'faren_tel.require' => '法人电话不能为空',
        'city_id.require' => '请选择省份',
        'se_city_id.require' => '请选择城市'
    ];

    protected $scene = [
        'add' => ['name', 'email', 'logo', 'license_logo', 'description', 'bank_info', 'bank_name', 'bank_user', 'faren', 'faren_tel','city_id','se_city_id'],

    ];
}



