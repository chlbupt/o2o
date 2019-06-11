<?php

namespace app\admin\controller;

use app\common\controller\Base;
use app\extend\Map;
use think\Controller;
use think\facade\Validate;
use app\admin\validate\Category as CategoryValidate;
use think\Request;
use app\common\model\Category as CategoryModel;

class Category extends Base
{

    public function index()
    {
        $parent_id = input('get.parent_id', 0, 'intval');
        $categorys = CategoryModel::where([
            ['parent_id', '=', $parent_id],
            ['status','neq', -1],
        ])->order([
            'listorder' => 'desc',
            'id' => 'desc'
        ])->paginate();
        return view()->assign(compact('categorys'));
    }
    public function map(){
        return Map::staticimage('116.403874,39.914888');
    }
    public function create(){
        $where =  [
            'status' => 1,
            'parent_id' => 0
        ];
        $categorys = CategoryModel::where($where)->order('id', 'desc')->select();
        return view()->assign(compact('categorys'));
    }

    public function update($data){
        $category = CategoryModel::get($data['id']);
        $category['name'] = $data['name'];
        $category['parent_id'] = $data['parent_id'];
        if( $category->save()){
            $this->success('更新成功');
        }else{
            $this->error('更新失败');
        }
    }

    public function add($data){
        $data['status'] = 1;
        if(CategoryModel::create($data)){
            $this->success('新增成功');
        }else{
            $this->error('新增失败');
        }
    }

    public function save(Request $request)
    {
        if(!$request->isPost()){
            $this->error('请求失败');
        }
        $data = $request->post();
        $validate = new CategoryValidate();
        if(!$validate->scene('add')->check($data)){
            return $this->error($validate->getError());
        }
        // 更新逻辑
        if(isset($data['id']) && $data['id']){
            return $this->update($data);
        }else{
            $this->add($data);
        }
    }

    public function edit($id=0)
    {
        if(intval($id) < 1){
            $this->error('参数不合法');
        }
        $info = CategoryModel::get($id);
        $categorys = CategoryModel::where([
            'status' => 1,
            'parent_id' => 0
        ])->order('id', 'desc')->select();
        return view()->assign(compact('categorys', 'info'));
    }

    public function listorder($id, $listorder){
        $listorder = floor($listorder);
        if( $res = CategoryModel::where('id', $id)->update(compact('listorder')) ){
            $this->result($_SERVER['HTTP_REFERER'], 0, '更新成功');
        }else{
            $this->result($_SERVER['HTTP_REFERER'], 1, '更新失败');
        }
    }

    // 修改状态
    /*public function status($id, $status){
        $validate = new CategoryValidate();
        if(!$validate->scene('status')->check(compact('id', 'status'))){
            return $this->error($validate->getError());
        }
        if( CategoryModel::where('id', $id)->update(compact('status')) ){
            $this->success('状态更新成功');
        }else{
            $this->error('状态更新失败');
        }
    }*/
}
