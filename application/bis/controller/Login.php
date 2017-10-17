<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/13
 * Time: 下午2:50
 */

namespace app\bis\controller;

use think\Controller;
use think\Session;

class Login extends Controller
{

    public function index()
    {

        //判断session
        if (session('loginUser', '', 'bis')) {
            //直接跳转到Index
            $this->redirect('bis/index/index');
        }

        if (request()->isPost()) {
            $data = input('post.');
            //数据校验
            $validate = validate('BisAccount');

            $res = $validate->scene('login')->check($data);

            if (!$res) {
                $this->error($validate->getError());
            }

            //根据用户名获取信息

            $res = model('BisAccount')->get([
                'username' => $data['username']
            ]);

            if (!$res) {
                $this->error('该用户不存在或者发生未知的错误');
            }

            //匹配密码
            if ($res->password != md5($data['password'] . $res->code)) {
                $this->error('登录失败');
            }

            //存入session

            session('loginUser', $res, 'bis');

            $this->success('登录成功', url('bis/index/index'));
        } else {

        }
        return $this->fetch();
    }

    //退出登录

    public function logout()
    {
        //session置空
        Session::delete('loginUser','bis');
        //调回登录

        $this->redirect('bis/login/index');
    }

//    public function indexTest()
//    {
//
//        $to = '804653938@qq.com';
//
//        $title = '测试一下';
//
//        $content = '你的账号被封10年,<a href="http://www.baidu.com" style="color: red;font-size: 30px" target="_blank">点击查看</a>';
//
//
//        $res = \phpmailer\Email::send($to,$title,$content);
//
//        if (!$res) {
//            $this->error('邮件发送失败');
//        }
//
//        $this->success('发送成功');
//    }
}





