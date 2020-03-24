<?php

use Illuminate\Http\Request;

//系统管理相关的路由，涉及基础数据的管理和维护
Route::post("getvpusers","Admin\GetVpUsers");

//删除公告
Route::post("deletenews","Admin\Sys\DeleteNews");
