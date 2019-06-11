<?php

namespace app\api\controller;

use think\Controller;
use think\Request;
use app\common\model\Category as CategotyModel;

class Category extends Controller
{
    public function getCategorysByParentId()
    {
        $id = input('post.id');
        if(!$id){
            $this->error('Id 不合法');
        }
        $categorys = CategotyModel::where([
            'status' => 1,
            'parent_id' => $id,
        ])->field(['name', 'id'])->order('id', 'desc')->select();
        if(!$categorys){
            return $this->result('', 1, 'error');
        }
        $this->result(compact('categorys'), 0, 'success');
    }
}
