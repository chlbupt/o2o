<?php

namespace app\index\controller;

use League\Flysystem\Exception;
use think\Controller;
use think\Request;
use app\common\utils\CommonUtils;
use app\extend\phpmailer\Email as EmailModel;

class Weixinpay extends Base
{
    use CommonUtils;

    public function notify()
    {
        /*$weixinData = file_get_contents('php://input');
        file_put_contents('/tmp/2.txt', $weixinData, FILE_APPEND);
        try{
            $resultObj = new \WxPayResults();
            $weixinData = $resultObj->Init($weixinData);
        }catch(Exception $e){
            $resultObj->setData('return_code', 'FAIL');
            $resultObj->setData('return_msg', $e->getMessage());
            return $resultObj->toXml();
        }*/
        // fake data
        $out_trade_no = input('get.out_trade_no');
        $price = input('get.price');
        $buy_count = input('get.buy_count');
        $weixinData = [
            'appid' => 'wx59bb463341091e64',
            'attahc' => '支付 '.$price.'元',
            'bank_type' => 'CFT',
            'cash_free' => $price * 100,
            'is_subscribe' => 'Y',
            'mch_id' => '1448773002',
            'nonce_str' => '3ovh61d116nclzr7n6jzwhdcp7zzt3oc',
            'openid' => 'oC5ViwFeZ1_0q0C9SLzIBUi2LL7Y',
            'out_trade_no' => $out_trade_no,
            'result_code' => 'SUCCESS',
            'return_code' => 'SUCCESS',
            'sign' => '2FBE4525E9D4601142222223',
            'time_end' => time(),
            'total_fee' => $price * $buy_count * 100,
            'trade_type' => 'NATIVE',
            'transation_id' => '4004102001201703203974903406',
        ];
//        $resultObj = new \WxPayResults();
        if($weixinData['return_code'] == 'FAIL'){
//            $resultObj->setData('return_code', 'FAIL');
//            $resultObj->setData('return_msg', 'ERROR');
//            return $resultObj->toXml();
        }

        $outTradeNo = $weixinData['out_trade_no'];
        $order = model('Order')->get(['out_trade_no' => $outTradeNo]);
        if(!$order || $order['pay_status'] == 1){
//            $resultObj->setData('return_code', 'SUCCESS');
//            $resultObj->setData('return_msg', 'OK');
        }

        // 更新 订单表和商品表
        try{
            $total_fee = $this->P_from_array($weixinData, 'total_fee', 0);
            $data = [
                'transation_id' => $this->P_from_array($weixinData, 'transation_id', ''),
                'pay_amount' => $total_fee / 100,
                'pay_time' => $this->P_from_array($weixinData, 'time_end'),
                'pay_status' => 1,
            ];
            model('Order')->where('out_trade_no', $outTradeNo)->update($data);
            model('Deal')->updateBuyCountById($order['deal_id'], $order['deal_count']);

            // 消费券
            $coupons = [
                'sn' => $outTradeNo,
                'password' => rand(10000, 99999),
                'user_id' => $order['user_id'],
                'deal_id' => $order['deal_id'],
                'order_id' => $order['id'],
            ];
            model('Coupon')->create($coupons);

            // 发送邮件
            EmailModel::send($this->account['email'], '消费券发放', '顾客您好，消费券已发放，请查收');

        }catch(Exception $e){
            return false;
        }
        sleep(1);
        $this->redirect('api/order/paystatus', ['id' => $order['id']]);

//        $resultObj->setData('return_code', 'SUCCESS');
//        $resultObj->setData('return_msg', 'OK');
//        return $resultObj->toXml();
    }
}
