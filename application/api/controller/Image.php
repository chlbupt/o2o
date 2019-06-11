<?php

namespace app\api\controller;

use think\Controller;
use think\Request;
use think\File;

class Image extends Controller
{
    public function upload()
    {
        $file = request()->file('file');
        $info = $file->move('upload');
        if($info && $info->getPathname()){
            $this->result('/'.$info->getPathname(), 0, 'success');
        }else{
            $this->result('', 1, 'upload error');
        }
    }
}
