<?php
// api/token/resource

/*************************    文件前端接口   ***********************************/
//获取文件列表
Route::post("getresourcelist","Resource\GetResourceList")->middleware('login');
//获取轮播图
Route::post("getbanner","Resource\GetBanner");