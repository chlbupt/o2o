<?php

// 后台管理
Route::group(['prefix' => 'admin'], function(){
    // 登录展示界面
    Route::get('/category', '/admin/category/index');
    Route::get('/category/create', '/admin/category/create');
});