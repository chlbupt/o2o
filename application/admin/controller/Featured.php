<?php

namespace app\admin\controller;

use app\common\controller\Base;
use think\Controller;
use think\Request;
use think\Db;

class Featured extends Base
{

    public function index(){
        $type = input('get.type');
        $condition = [
            ['type', '=', $type],
            ['status', '<>', -1],
        ];
        if(!$type){
            array_shift($condition);
        }
        $datas = model('Featured')->where($condition)->order('id', 'desc')->paginate(  );
//        dump(DB::getLastSql());
        $types = config('featured.featured_type');
        $this->assign('types', $types);
        $this->assign('type', $type);
        $this->assign('datas', $datas);
        return view();
    }

    public function add(){
        $types = config('featured.featured_type');
        $this->assign('types', $types);
        return view();
    }

    public function store(){
        $data = input('post.');
        $info = model('Featured')->create($data);
        if($info){
            return $this->success('添加成功');
        }else{
            return $this->error('添加失败');
        }
    }
}
