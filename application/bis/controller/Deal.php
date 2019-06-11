<?php

namespace app\bis\controller;

use app\extend\Map;
use think\Controller;
use app\common\model\City as CityModel;
use app\common\model\Category as CategoryModel;
use app\common\model\BisLocation as BisLocationModel;
use app\common\model\Deal as DealModel;

class Deal extends Base
{
    public $bis_id;
    public $account_id;

    public function initialize()
    {
        $info = $this->getLoginUser();
        $this->bis_id = $info['bis_id'];
        $this->account_id = $info['id'];
    }

    public  function  index(){
        return view();
    }

    public  function add(){
        $citys = CityModel::where([
            'status' => 1,
            'parent_id' => 0,
        ])->order('id', 'desc')->select();
        $categorys = CategoryModel::where([
            'status' => 1,
            'parent_id' => 0,
        ])->order('id', 'desc')->select();
        $bislocations = BisLocationModel::where([
            'status' => 1,
            'bis_id' => $this->bis_id,
        ])->order('id', 'desc')->select();
        return view()->assign(compact('citys', 'categorys', 'bislocations'));
    }

    public function store(){
        $data = input('post.');
        $locationInfo = BisLocationModel::get($data['location_ids'][0]);

        $dealData = [
            'bis_id' => $this->bis_id,
            'name' => $data['name'],
            'image' => $data['image'],
            'category_id' => $data['category_id'],
            'se_category_id' => empty($data['se_category_id'])? '' : implode(',', $data['se_category_id']),
            'city_id' => $data['city_id'],
            'location_ids' => empty($data['location_ids'])? '' : implode(',', $data['location_ids']),
            'start_time' => strtotime( $data['start_time']),
            'end_time' => strtotime($data['end_time']),
            'total_count' => $data['total_count'],
            'origin_price' => $data['origin_price'],
            'current_price' => $data['current_price'],
            'coupons_begin_time' => strtotime( $data['coupons_begin_time']),
            'coupons_end_time' => strtotime($data['coupons_end_time']),
            'notes' => $data['notes'],
            'description' => $data['description'],
            'bis_account_id' => $this->account_id,
            'xpoint' => $locationInfo['xpoint'],
            'ypoint' => $locationInfo['ypoint'],
        ];

        $info = DealModel::create($dealData);
        if($info['id']){
            $this->success('添加成功', url('deal/index'));
        }else{
            $this->error('添加失败');
        }
    }
}
