<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/16
 * Time: 下午8:25
 */


namespace app\common\model;

use think\Model;

class Bis extends Model
{
    protected $autoWriteTimestamp = true;

    public function add($data)
    {
        $data['status'] = 0;

        $this->save($data);

        return $this->id;
    }
}
