<?php

// 后台管理
Route::group(['prefix' => 'api'], function(){
    // 登录展示界面
    Route::post('/getCitysByParentId', '/api/city/getCitysByParentId');
});