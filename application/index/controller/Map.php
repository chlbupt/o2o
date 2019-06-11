<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use app\extend\Map as MapModel;

class Map extends Controller
{
    public function getMapImage($data){
//        halt(MapModel::staticimage($data));
        return MapModel::staticimage($data);
    }
}
