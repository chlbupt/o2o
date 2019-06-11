<?php

namespace app\index\controller;

use think\Controller;
use think\Request;

class Detail extends Base
{
    public function  index($id){
        if(!intval($id)){
            $this->error('ID不合法');
        }
        $deal = model('Deal')->get($id);
        if(!$deal || $deal['status'] != 1){
            $this->error('该商品不存在');
        }

        $category = model('Category')->get($deal['category_id']);
        $locations = model('BisLocation')->getNormalLocationsInId($deal['location_ids']);
        $flag = 0;
        if($deal->start_time > time()){
            $flag = 1;
            $dtime = $deal->start_time - time();
            $d = floor($dtime/(24*3600));
            $h = floor($dtime%(24*3600)/3600);
            $m = floor($dtime%(24*3600)%3600/60);
            $timedata = sprintf('%d 天 %d 小时 %d 分', $d, $h, $m);
        }
        $map = $locations[0]['xpoint'].','.$locations[0]['ypoint'];
//        $map = '北京市海淀区温泉镇老年医院';
//        halt($map);
        return view()->assign(compact('deal', 'category', 'locations', 'flag', 'timedata', 'map'));
    }
}
