<?php
namespace app\Admin\controller;

use think\Controller;

class Index extends Controller
{
    public function index()
    {

        $data = [
            'name' => '李建武',
            'age' => 18
        ];


        return $this->fetch('',[
            'person' => $data
        ]);
    }
}
