<?php
namespace app\bis\controller;
use Blackfire\Profile\Request;
use think\Facade\Session;
use think\Controller;
use app\common\model\BisAccount as BisAccountModel;

class Login extends Controller
{
    public function index(){
        $account = session('bisAccount', '', 'bis');
        if($account && $account['id']){
            return $this->redirect(url('index/index'));
        }
        return view();
    }

    public function login(){
        $data = input('post.');
        $ret = BisAccountModel::where(['username' => $data['username']])->find();
        if(!$ret || $ret['status'] != 1 ){
            $this->error('该用户不存在或审核未通过');
        }
        if($ret['password'] != md5($data['password'].$ret['code'])){
            $this->error('密码不正确');
        }
        model('BisAccount')::where(['id' => $ret['id']])->update(['last_login_time' => time()]);
        session('bisAccount', $ret, 'bis');

        return $this->success('登录成功', '/bis/index');
    }

    public function logout(){
//        session( null, 'bis');
        Session::delete('bisAccount', 'bis');
        $this->redirect(url('login/index'));
    }
}