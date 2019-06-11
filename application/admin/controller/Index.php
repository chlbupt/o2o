<?php
namespace app\admin\controller;

use think\Controller;
use app\extend\Map;
use app\extend\phpmailer\Email;

class Index extends Controller
{
    public function index()
    {
        return view();
    }
    public function test(){
        print_r(Map::getLngLat('北京市海淀区上地十街10号'));
    }
    public function test2(){
        return Map::staticimage('北京市海淀区上地十街10号');
    }
    public function welcome()
    {
//        $res = Email::send('1032326058@qq.com', '邮件测试', time());
        return '欢迎来到O2O主后台首页';
    }
}
