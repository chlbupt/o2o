<?php
namespace app\extend;

class Map
{
    public static function getLngLat($address){
        if(!$address) return '';
        $ak = config('map.ak');
//        $sk = config('map.sk');
        $uri = config('map.geocoder');
        $output = 'json';
        $querystring_arrays = compact('ak', 'output', 'address');
        /*$sn = self::getSn($sk, $uri, $querystring_arrays);
        $querystring_arrays['sn'] = $sn;*/
        $url = config('map.baidu_map_url').$uri.'?'.http_build_query($querystring_arrays);
        $result = doCurl($url);
        if($result){
            return json_decode($result, true);
        }else{
            return [];
        }
    }

    public static function getSn($sk, $uri, $querystring_arrays){
        return self::caculateAKSN($sk, $uri, $querystring_arrays);
    }

    static function  caculateAKSN($sk, $url, $querystring_arrays, $method = 'GET')
    {
        if ($method === 'POST'){
            ksort($querystring_arrays);
        }
        $querystring = http_build_query($querystring_arrays);
        return md5(urlencode($url.'?'.$querystring.$sk));
    }

    public static function staticimage($center)
    {
        if(!$center) return false;
        $ak = config('map.ak');
        $width = config('map.width');
        $height = config('map.height');
        $markers = $center;
        $querystring_arrays = compact('ak', 'width', 'height', 'center', 'markers');
        $url = config('map.baidu_map_url').config('map.staticimage').'?'.http_build_query($querystring_arrays);
        return doCurl($url);
    }
}