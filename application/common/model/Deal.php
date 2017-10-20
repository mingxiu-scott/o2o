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

    public function getAllNormalDeals()
    {
        $data = [
          'status' => 1
        ];

        $order = [
            'listorder' => 'desc',
            'id' => 'desc'
        ];

        return $this->where($data)->order($order)->paginate(3);
    }

}