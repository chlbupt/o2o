<?php
namespace app\common\utils;

trait CommonUtils
{
    public function P_from_array(&$arr, $name, $default = NULL)
    {
        if ($arr && isset($arr[$name]))
        {
            return $arr[$name];
        }
        return $default;
    }

    public function printStr($str){
        echo $str;
    }
}
