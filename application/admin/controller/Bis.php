<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/17
 * Time: 下午4:18
 */

namespace app\admin\controller;

use think\Controller;

class Bis extends Controller
{
    private $obj;

    protected function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub

        $this->obj = model('Bis');
    }

    public function index()
    {
        //显示status为1的商户

        $res = $this->obj->getBisByStatus(1);


        return $this->fetch('',[
            'bis' => $res
        ]);
    }
    public function apply()
    {
        //显示status为0的商户

        $res = $this->obj->getBisByStatus(0);


        return $this->fetch('',[
            'bis' => $res
        ]);

    }
    public function dellist()
    {
        $res = $this->obj->getBisByStatus(2);

        return $this->fetch('',[
            'bis' => $res
        ]);

    }
}
