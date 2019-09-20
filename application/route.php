<?php
use think\Route;
Route::get('/',function(){
    return 'Hello,world!';
});
Route::pattern([
    'name'  =>  '\w+',
    'id'    =>  '\d+',
]);
Route::get('news/:name','index/News/read');//查询
Route::post('news','index/News/add'); //新增
Route::put('news/:id','index/News/update'); //修改
Route::delete('news','index/News/delete'); //删除
//Route::any('new/:id','News/read'); // 所有请求都支持的路由规则
Route::get('tables/:name','index/Tables/fetch');//查询
Route::post('tables','index/Tables/search'); //新增
Route::put('tables','index/Tables/update'); //修改
Route::delete('tables/:id','index/Tables/delete'); //删除

Route::get('Used/:name','index/Used/fetch');//查询
Route::post('Used','index/Used/search'); //新增
Route::put('Used','index/Used/update'); //修改
Route::delete('Used/:id','index/Used/delete'); //删除