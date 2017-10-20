<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/19
 * Time: 下午2:17
 */

namespace app\common\model;

use think\Model;

class Deal extends Model
{

    public function getAllNormalDeals($bis_id = 0)
    {
        $data = [
            'status' => ['neq', -1],
            'bis_id' => $bis_id

        ];

        $order = [
            'listorder' => 'desc',
            'id' => 'desc'
        ];


        return $this->where($data)->order($order)->paginate(3);
    }

    public function getDealsByCondition($data = [])
    {
        $order = [
            'listorder' => 'desc',
            'id' => 'desc'
        ];

        $res = $this->where($data)->order($order)->paginate(2);
        print_r($this->getLastSql());

        return $res;
    }

}