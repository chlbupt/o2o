<?php
namespace app\index\controller;
use think\Controller;
use think\Db;

class Index extends Base
{
    public function index()
    {
        // 获取轮播图
        $commendPics = model('Featured')->where([
            'status' => 1,
            'type' => 1
        ])->order('listorder', 'desc')->limit(5)->select();
        $adPics = model('Featured')->where([
            'status' => 1,
            'type' => 2
        ])->order('listorder', 'desc')->limit(5)->select();

        $results = [];
        foreach($this->recommendIds as $recommendId){
            $results[$recommendId]['goodsInfo'] = model('Deal')->getNormalDealByCategoryCityId($recommendId, $this->city->id);
            $results[$recommendId]['cateName'] = model('Category')->where('id',$recommendId)->column('name');
            $results[$recommendId]['subCates'] = model('Category')->getNormalRecommendCategoryByParentId($recommendId, 4);
        }
//        dump($results);
        return view()->assign(compact('commendPics', 'adPics', 'results'));
    }

}
