<?php

namespace app\bis\controller;

use think\Controller;

class Base extends Controller
{
    public $account;
    public function initialize()
    {
//        dump($this->isLogin());
        if( !$this->isLogin() ){
            return $this->redirect(url('login/index'));
        }
    }

    public function isLogin()
    {
        $user = $this->getLoginUser();
        if($user && $user['id']){
            return true;
        }
        return false;
    }

    public function getLoginUser()
    {
        if(!$this->account) {
            $this->account = session('bisAccount', '', 'bis');
        }
        return $this->account;
    }
}
