<?php
namespace app\index\controller;
use app\index\validate\Register;
use think\Controller;
use think\Db;

class User extends Controller
{
    public function login()
    {
        $user = session('o2o_user', '', 'o2o');
        if($user){
            return $this->redirect('index/index');
        }
        return view()->assign([
            'title' => '登录',
        ]);
    }

    public function doLogin(){
        $data = input('post.');
        // 校验
        $info = model('User')->where(['username' => $data['username']])->find();
//        halt(Db::getLastSql());
        if(empty($info) || (isset($info['status']) && $info['status'] != 1) ){
            return $this->error('该用户不存在');
        }
        if(md5($data['password'].$info['code']) != $info['password']){
            return $this->error('密码不正确');
        }

        model('User')->where('id', $info['id'])->update([
            'last_login_time' => time(),
        ]);

        session('o2o_user', $info, 'o2o');
        $this->success('登录成功', url('index/index'));
    }

    public function register()
    {
        return view('user/register')->assign([
            'title' => '注册',
        ]);
    }

    public function store()
    {
        $data = input('post.');
        if (!captcha_check($data['verifyCode'])) {
            return $this->error('验证码不正确');
        }
        $validate = new Register();
        if (!$validate->scene('register')->check($data)) {
            return $this->error($validate->getError());
        }
        $data['code'] = mt_rand(100, 10000);
        $data['password'] = md5($data['password'] . $data['code']);
        $data['status'] = 1;
        $info = model('User')->create($data);
        if ($info) {
            return $this->success('注册成功', url('user/login'));
        } else {
            return $this->error('注册失败');
        }
    }

    public function logout(){
        session( null, 'o2o');
        $this->redirect(url('user/login'));
    }
}
