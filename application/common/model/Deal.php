<?php

namespace app\common\model;

use think\Model;
use app\common\model\City;

class Deal extends Model
{
    public function citys(){
            return $this->belongsTo('City', 'city_id', 'id');
    }

    public function categorys(){
        return $this->belongsTo('Category', 'category_id', 'id');
    }

    public function getNormalDealByCategoryCityId($id, $cityId, $limit=10) {
        $data  = [
            ['end_time' ,'>', time()],
            ['category_id', '=', $id],
            ['city_id', '=', $cityId],
            ['status', '=', 1],
        ];

        $order = [
            'listorder'=>'desc',
            'id'=>'desc',
        ];

        $result = $this->where($data)
            ->order($order);
        if($limit) {
            $result = $result->limit($limit);
        }
        return $result->select();
    }

    public function getDealByConditions($S = [], $orders){
        $order = [];
        if($orders){
            if($orders == 'order_sales'){
                $order['buy_count'] = 'desc';
            }else if($orders == 'order_price'){
                $order['current_price'] = 'desc';
            }else{
                $order['create_time'] = 'desc';
            }
        }
        $order['id'] = 'desc';
        $condition = [];
        if(isset($S['se_category_id']) && $S['se_category_id']){
            $condition[] = "find_in_set(".$S['se_category_id'].", se_category_id)";
        }
        if(isset($S['category_id']) && $S['category_id']){
            $condition[] = "category_id = {$S['category_id']}";
        }
        $condition[] = "status = 1";
        if(isset($S['city_id']) && $S['city_id']){
            $condition[] = "city_id = {$S['city_id']}";
        }
        $condition[] = "end_time > ".time();
        $result = $this->where(implode(' AND ', $condition))->order($order)->paginate();
        return $result;
    }

    public function updateBuyCountById($id, $buyCount){
        return $this->where(['id' => $id])->setInc('buy_count', $buyCount);
    }
}
