<?php

namespace app\api\controller;

use think\Controller;
use think\Request;
use app\common\utils\ResponseJson;

class Order extends Controller
{
    use ResponseJson;
    public function paystatus(){
        $id = input('get.id', 0, 'intval');
        if(!$id){
            $this->error('参数非法');
        }
        $order = model('Order')->find(['id' => $id]);
//        halt($order);
        if($order && $order['pay_status'] == 1){
//            return $this->jsonSuccessData();
            $this->redirect('index/pay/paysuccess');
        }else{
//            return $this->jsonData(1, 'error');
            $this->redirect('index/pay/index');
        }
    }
}
