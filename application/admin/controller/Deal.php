<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use app\common\utils\CommonUtils;
use app\common\controller\Base;

class Deal extends Base
{
    use CommonUtils;
    public function search($data){
        $S = array();
        if(!empty($data['city_id'])){
            $S[] = ['city_id', '=', $data['city_id']];
        }
        if(!empty($data['category_id'])){
            $S[] = ['category_id', '=', $data['category_id']];
        }
        if(!empty($data['start_time']) && !empty($data['start_time']) ){
            $S[] = [
                ['create_time', 'gt', $data['start_time']],
                ['create_time', 'lt', $data['end_time']],
            ];
        }
        if(!empty($data['name'])){
            $S[] = ['name', 'like', '%'.$data['name'].'%'];
        }
        return $S;
    }
    public function index()
    {
        $data = input('get.', '', 'htmlentities');
        $S = $this->search($data);
        $name = $this->P_from_array($data, 'name', '');
        $category_id = $this->P_from_array($data, 'category_id', '');
        $city_id = $this->P_from_array($data, 'city_id', '');
        $start_time = $this->P_from_array($data, 'start_time', '');
        $end_time = $this->P_from_array($data, 'end_time', '');
        $deals = model('Deal')->with('citys')->where($S)->order('id', 'desc')->paginate();
//        halt($deals);
//        dump(Db::getLastSql());
        $citys = model('City')->where([
            ['status', '=', 1],
            ['parent_id', '>', 0]
        ])->order('id', 'desc')->select();

        $categorys = model('Category')->where([
            ['status', '=', 1],
            ['parent_id', '=', 0]
        ])->order('id', 'desc')->select();
        return view()->assign(compact('citys', 'categorys', 'deals', 'name', 'category_id', 'city_id', 'start_time', 'end_time'));
    }
}
