<?php

namespace app\index\controller;

use think\Controller;

class Order extends Base
{
    public function confirm(){
        $controller = 'pay';
        $user = $this->account;

        $id = input('get.id', 0, 'intval');
        if(!$id){
            $this->error('参数不合法');
        }

        $count = input('get.count', 1, 'intval');
        $deal = model('Deal')->find($id);
        if(!$deal || $deal['status'] != 1){
            $this->error('商品不存在');
        }

        return view()->assign(compact('controller', 'count', 'deal'));
    }

    public function  index(){
        $user = $this->account;
        $id = input('get.id', 0, 'intval');
        if(!$id){
            $this->error('参数不合法');
        }
        $dealCount = input('get.deal_count', 0, 'intval');
        $totalPrice = input('get.total_price');

        $deal = model('Deal')->find($id);
        if(!$deal || $deal['status'] != 1){
            $this->error('商品不存在');
        }
        if(!$_SERVER['HTTP_REFERER']){
            $this->error('请求不合法');
        }

        $out_trade_no = setOrderSn();
        $user_id = $user->id;
        $username = $user->username;
        $deal_id = $id;
        $deal_count = $dealCount;
        $total_price = $totalPrice;
        $referer = $_SERVER['HTTP_REFERER'];
        $info = model('Order')->create(compact('out_trade_no', 'user_id', 'username', 'deal_id', 'deal_count', 'total_price', 'referer'));
        if($info){
            $this->redirect(url('pay/index', ['id' => $info['id']]));
        }
    }
}
