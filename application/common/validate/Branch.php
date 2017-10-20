<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/19
 * Time: 上午9:40
 */

namespace app\common\validate;

use think\Validate;

class Branch extends Validate
{
    protected $rule = [
        'name' => 'require',
        'city_id' => 'require',
        'logo' => 'require',
        'tel' => 'require',
        'contact' => 'require',
        'open_time' => 'require',
        'category_id' => 'require',
        'address' => 'require'
    ];

    protected $message = [
        'name.require' => '店铺名称不为空',
        'city_id.require' => '请选择城市',
        'logo.require' => '请上传图片',
        'tel.require' => '联系人电话不能为空',
        'contact.require' => '联系人姓名不能为控股',
        'open_time.require' => '内容不能为空',
        'category_id.require' => '请选择分类',
        'address.require' => '请填写地址'
    ];

    protected $scene = [
        'add' => ['tel', 'contact', 'open_time', 'content', 'category_id','name','city_id','logo',]
    ];
}
