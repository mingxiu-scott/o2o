<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/16
 * Time: 下午8:15
 */

namespace app\common\model;

use think\Model;

class BisAccount extends Model {

    protected $autoWriteTimestamp = true;

    public function add($data){

        $data['status'] = 0;
        $this->save($data);

        return $this->id;
    }

    //根据用户名获取是否存在这个用户
    public function getAccountByUsername($uesrname){
        $data = [
            'username' => $uesrname,
        ];

        return $this->where($data)->find();
    }

}

