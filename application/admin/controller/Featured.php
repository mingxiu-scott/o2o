<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/23
 * Time: 上午10:03
 */
namespace app\admin\controller;

use think\Controller;

class Featured extends Controller
{
    private $obj;

    protected function _initialize()
    {
        $this->obj = model('Featured');
    }

    public function index()
    {


        if (request()->isPost()) {
            $type = input('type');
            //条件数据判断
            $res = $this->obj->getFeaturedByType($type);

        }
        else{
            $res = $this->obj->getAllFeatured();
            $type = 0;
        }

        $types = config('featured.featured_type');


        return $this->fetch('', [
            'data' => $res,
            'types' => $types,
            'type' => $type
        ]);
    }

    public function status()
    {
        $id = input('id', 0, 'intval');

        $status = input('status', 0, 'intval');

        $res = $this->obj->save(['status' => $status], ['id' => $id]);

        if (!$res) {
            $this->error('状态更新失败');
        } else {
            $this->success('状态更新成功');
        }

    }

    public function add()
    {

        if (request()->isPost()) {
            $data = input('post.');

            //校验成功 ....

            //加到数据库
            $res = $this->obj->save($data);

            if (!$res) {
                $this->error('添加失败');
            }
            $this->success('添加成功');

        } else {

            //获取推荐位信息
            $types = config('featured.featured_type');

            return $this->fetch('', [
                'types' => $types
            ]);

        }
    }
}
