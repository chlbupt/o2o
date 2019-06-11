<?php

namespace app\index\controller;

use think\Controller;

class Lists extends Base
{
    function index(){
        $firstCateIds = [];

        $categorys = model('Category')->getNormalCategoryByParentId();
        foreach($categorys as $category){
            $firstCateIds[] = $category->id;
        }
        $id = input('get.id', 0, 'intval');
        $search= [];
        if(in_array($id, $firstCateIds)){
            $categoryParentId = $id;
            $search['category_id'] = $id;
        }elseif($id){
            $category = model('Category')->get($id);
            if(!$category || $category->status != 1){
                $this->error('数据不合法');
            }
            $categoryParentId = $category->parent_id;
            $search['se_category_id'] = $id;
        }else{
            $categoryParentId = 0;
        }
        $seccategorys = [];
        if($categoryParentId){
            $seccategorys = model('Category')->getNormalCategoryByParentId($categoryParentId);
        }
        $order_sales = input('get.order_sales', '');
        $order_price = input('get.order_price',  '');
        $order_time = input('get.order_time', '');
        $orderFlag = '';
        if($order_sales){
            $orderFlag = 'order_sales';
        }elseif($order_price){
            $orderFlag = 'order_price';
        }elseif($order_time){
            $orderFlag = 'order_time';
        }
        $search['city_id'] = $this->city->id;
        $deals = model('Deal')->getDealByConditions($search, $orderFlag);
        return view()->assign(compact('categorys', 'id', 'categoryParentId', 'seccategorys', 'orderFlag', 'deals'));
    }
}
