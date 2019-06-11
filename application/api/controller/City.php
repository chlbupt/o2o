<?php

namespace app\api\controller;

use think\Controller;
use think\Request;
use app\common\model\City as CityModel;

class City extends Controller
{
    public function getCitysByParentId()
    {
        $id = input('post.id');
        if(!$id){
            $this->error('Id 不合法');
        }
        $citys = CityModel::where([
            'status' => 1,
            'parent_id' => $id,
        ])->field(['name', 'id'])->order('id', 'desc')->select();
        if(!$citys){
            return $this->result('', 1, 'error');
        }
        $this->result(compact('citys'), 0, 'success');
    }
}
