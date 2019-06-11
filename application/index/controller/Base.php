<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use think\Db;
use app\common\utils\CommonUtils;
use think\Log;

class Base extends Controller
{
    use CommonUtils;

    public $city;
    public $account;
    public $recommendIds;

    public function initialize()
    {
        $citys = model('City')->where([
            ['status', '=', '1'],
            ['parent_id', '<>', '0']
        ])->select();
        $this->getCity($citys);
        $this->getLoginUser();
        $this->isLogin();
        $cats = $this->getRecommendCates();

        $this->assign('citys', $citys);
        $this->assign('cats', $cats);
        $this->assign('city', $this->city);
        $this->assign('controller', strtolower(request()->controller()));
        $this->assign('user', $this->account);
    }

    function getCity($citys){
        $city = array_filter($citys->toArray(), function($vo){
            return $vo['is_default'] == 1 ? true : false;
        });
        $city = array_pop($city)['uname'];
        $default_city = $city ?  $city : 'beijing';
        $defaultuname = input('get.city', $default_city , 'trim');
        if(session('cityuname', '', 'o2o') && !input('get.city')){
            $cityuname = session('cityuname', '', 'o2o');
        }else{
            $cityuname = input('get.city', $defaultuname, 'trim');
            session('cityuname', $defaultuname, 'o2o');
        }
        $this->city = model('City')->where(['uname' => $cityuname])->find();
    }

    public function getLoginUser(){
        if(!$this->account){
            $this->account = session('o2o_user', '', 'o2o');
        }
        return $this->account;
    }

    public function isLogin(){
        if(!$this->getLoginUser()){
            $this->error('请登录', url('user/login'));
        }
    }

    public function getRecommendCates(){
        // 获取一级分类的ID
        $ids = model('Category')->where([
            ['status', '=', 1],
            ['parent_id', '=', 0]
        ])->order(['listorder' => 'desc', 'id' => 'desc'])->limit(5)->column('id');
        $this->recommendIds = $ids;

        $resp = Db::name('category')->alias('c1')->leftJoin('category c2', 'c1.id=c2.parent_id')->whereIn('c1.id', $ids)->field(['c1.id as cid', 'c1.name as cname','c2.id', 'c2.name'])->order('c1.listorder', 'desc')->select();
        $result = [];
        foreach($resp as  $item){
            $sons = [
                'id' => $this->P_from_array($item, 'id', ''),
                'name' => $this->P_from_array($item, 'name', '')
            ];
            $result[$item['cid']]['name'] = $item['cname'];
            $result[$item['cid']]['sons'][] = $sons;
        }
        return $result;
    }
}
