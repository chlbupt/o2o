<?php

// 应用公共文件
use app\common\model\City as CityModel;

function doCurl($url, $type=0, $data=[]){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    if($type == 1){
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

function status($status)
{
    $format = '<span class="label %s radius">%s</span>';
    switch ($status){
        case 1:
            $str = sprintf($format, 'label-success', '正常');
            break;
        case 0:
            $str = sprintf($format, 'label-danger', '待审');
            break;
        default:
            $str = sprintf($format, 'label-danger', '删除');
            break;
    }
    return $str;
}

function pagination($obj){
    if(!$obj) return '';
    $params = request()->param();
    return '<div class="cl pd-5 bg-1 bk-gray  tp5">'.$obj->appends($params)->render().'</div>';
}

function getSecCityName($path){
    if(empty($path)) return '';
    if(preg_match('/,/', $path)){
        $tmp = explode(',', $path);
        $cityId = array_pop($tmp);
    }else{
        $cityId = $path;
    }
    $city = CityModel::get($cityId);
    return $city['name'];
}

function countLocation($ids){
    if(!$ids) return 1;
    if(preg_match('/,/', $ids)){
        $arr = explode(',', $ids);
        return count($arr);
    }else{
        return 1;
    }
}

function setOrderSn(){
    list($t1,  $t2) = explode(' ', microtime());
    $t3 = explode('.', $t1*10000);
    return $t2.$t3[0].(rand(10000, 99999));
}