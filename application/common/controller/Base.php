<?php

namespace app\common\controller;

use think\Controller;
use think\Request;

class Base extends Controller
{
    public function status($id, $status){
        $model = request()->controller();
        $validate_path = join(['app', request()->module(), 'validate', $model], '\\');
        if(file_exists($validate_path)){
            $validate = new $validate_path;
            if(!$validate->scene('status')->check(compact('id', 'status'))){
                return $this->error($validate->getError());
            }
        }
        if( model($model)->where('id', $id)->update(compact('status')) ){
            return $this->success('状态更新成功');
        }else{
            return $this->error('状态更新失败');
        }
    }
}
