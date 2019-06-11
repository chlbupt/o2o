<?php

namespace app\common\model;

use think\Model;
use app\common\Utils\CommonUtils;

class Order extends Model
{
    use CommonUtils;
    public function deal(){
        return $this->hasOne('Deal', 'deal_id', 'id');
    }
}
