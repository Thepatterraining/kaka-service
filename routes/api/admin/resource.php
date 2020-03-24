<?php
// api/v2/admin/resource

/*************************    文件前端接口   ***********************************/
//获取文件列表
// Route::post("getresource","Resource\GetResource");
//上传
Route::post("upload","Admin\Resource\Upload");
//下载
Route::post("download","Admin\Resource\Download");
//添加轮播图信息
Route::post("addbanner","Resource\AddBanner");