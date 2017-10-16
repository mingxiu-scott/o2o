<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/12
 * Time: 上午9:37
 */

namespace app\admin\validate;

use think\Validate;

class Category extends Validate
{

    protected $rule = [
        //必须是数字,只能取1,0,-1
        'status' => 'number|in:-1,0,1',
        'name' => 'require|max:15',
        'parent_id' => 'number',
        'id' => 'number',
        'listorder'=>'number'
    ];


    protected $message = [
        'status.number' => '类型必须是数字|数字取值范围错误',
        'status.in' => '状态取值范围错误',
        'name.require' => '名字不能为空',
        'name.max' => '长度不能超过15',
        'parent_id.number' => '必须是数字',
        'id.number' => '必须是数字',
        'listorder.number' => '必须是数字'
    ];

    //设置场景
    protected $scene = [
        'add' => ['name', 'parent_id'],
        'status' => ['status','id'],
        'update' => ['name','id','parent_id'],
        'listorder'=> ['id','listorder']
    ];


}
