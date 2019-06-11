<?php

namespace app\bis\controller;

use think\Controller;
use app\common\model\City as CityModel;
use app\common\model\Category as CategoryModel;
use app\common\model\BisLocation as BisLocationModel;
use app\extend\Map;

class Location extends Base
{
    public function index(){
        return view();
    }

    public function add(){
        $citys = CityModel::where([
            'status' => 1,
            'parent_id' => 0,
        ])->order('id', 'desc')->select();
        $categorys = CategoryModel::where([
            'status' => 1,
            'parent_id' => 0,
        ])->order('id', 'desc')->select();
        return view()->assign(compact('citys', 'categorys'));
    }

    public function store(){
        $user = $this->getLoginUser();
        $bisId = $user['bis_id'];
        $data = input('post.');

        // 获取经纬度
        $lngLat = Map::getLngLat($data['address']);
        if(!$lngLat || $lngLat['status'] != 0 || $lngLat['result']['precise'] != 1){
            $this->error('无法获取数据或者匹配的地址不精准');
        }

        $data['cat'] = '';
        if(isset($data['se_category_id']) && $data['se_category_id']){
            $data['cat'] = implode('|', $data['se_category_id']);
        }
        $locationData = [
            'bis_id' => $bisId,
            'name' => $data['name'],
            'tel' => $data['tel'],
            'contact' => $data['contact'],
            'category_id' => $data['category_id'],
            'category_path' => $data['category_id'] . ',' . $data['cat'],
            'city_path' => empty($data['se_city_id']) ? $data['city_id'] :  $data['city_id'].','.$data['se_city_id'],
            'api_address' => $data['address'],
            'open_time' => $data['open_time'],
            'content' => empty($data['content']) ? '' : $data['content'],
            'is_main' => 0,
            'xpoint' => empty($lngLat['result']['location']['lng']) ? '' : $lngLat['result']['location']['lng'],
            'ypoint' => empty($lngLat['result']['location']['lat']) ? '' : $lngLat['result']['location']['lat'],
        ];
        halt($locationData);
        $info = BisLocationModel::create($locationData);
        if($info){
            return $this->success('门店申请成功');
        }else{
            return $this->error('门店申请失败');
        }
    }
}
