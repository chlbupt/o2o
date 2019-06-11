<?php

namespace app\index\controller;

use think\Controller;
use think\Db;
use app\common\model\Order as OrderModel;

class Pay extends Base
{
    public function index(){
        $orderId = input('get.id', 0, 'intval');
        if(!$orderId){
            $this->error('请求不合法');
        }
        $order = model('Order')->get($orderId);
        if(!$order || $order['status'] != 1 || $order['pay_status'] != 0){
            $this->error('无法进行该操作');
        }
        $deal = model('Deal')->get($order['deal_id']);
        // 生成二维码
        // $url = $this->getQrcode($order, $deal);
        $url = '/static/common/weixinpay.jpg';
        return view()->assign(compact('deal', 'order', 'url'));
    }
    public function getQrcode($order, $deal){
        $input = new WxPayUnifiedOrder();
        $notify = new NativePay();
        $input->SetBody($deal['name']);
        $input->SetAttach($deal['name']);
        $input->SetOut_trade_no($order['out_trade_no']);
        $input->SetTotal_fee($order['total_price'] * 100);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("QRCode");
        $input->SetNotify_url("http://139.199.7.39/index.php/index/weixinpay/notify");
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id($order['deal_id']);

        $result = $notify->GetPayUrl($input);
        if($result["code_url"]){
            $url = $result["code_url"];
        }else{
            $url = '';
        }
        // 模拟qrcode
        return $url;
    }

    function paysuccess(){

        return view();
    }
}
