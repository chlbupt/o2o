<?php

namespace app\common\model;

use think\Model;

class BisLocation extends Model
{
    public function getNormalLocationsInId($ids) {
        $data = [
            ['id' ,'in', $ids],
            [ 'status', '=', 1],
        ];
        return $this->where($data)
            ->select();
    }
}
