<?php

namespace app\admin\controller;

use app\common\model\BisAccount as BisAccountModel;
use app\common\model\BisLocation as BisLocationModel;
use think\Controller;
use think\Request;
use app\common\model\Bis as BisModel;
use app\common\model\City as CityModel;
use app\common\model\Category as CategoryModel;

class Bis extends Controller
{
    public function index()
    {
        $bis = BisModel::where(['status' => 1])->paginate();
        return view()->assign(compact('bis'));
    }

    public function apply(){
        $bis = BisModel::where([
            'status' => 0
        ])->order('id', 'desc')->paginate();
        return view()->assign(compact('bis'));
    }

    public function detail()
    {
        $id = input('get.id');
        if(empty($id)) $this->error('ID错误');
        $cities = CityModel::where([
            'status' => 1,
            'parent_id' => 0,
        ])->order('id', 'desc')->select();
        $categorys = CategoryModel::where([
            'status' => 1,
            'parent_id' => 0,
        ])->order('id', 'desc')->select();
        $bisData = BisModel::get($id);
        $locationData = BisLocationModel::get(['bis_id' => $id, 'is_main' => 1]);
        $accountData = BisAccountModel::get(['bis_id' => $id, 'is_main' => 1]);
        return view()->assign(compact('cities', 'categorys', 'bisData', 'locationData', 'accountData'));
    }

    public function status($id, $status){
        $bisRes = BisModel::where('id', $id)->update(compact('status'));
        $locationRes = BisLocationModel::where('bis_id', $id)->update(compact('status'));
        $accountRes = BisAccountModel::where('bis_id', $id)->update(compact('status'));
        if( $bisRes && $locationRes && $accountRes ){
            $this->success('状态更新成功');
        }else{
            $this->error('状态更新失败');
        }
    }
}
