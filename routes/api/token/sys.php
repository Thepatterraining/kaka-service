<?php

use Illuminate\Http\Request;

//查询首页公告
Route::post("getnews","News\GetNews");

//查询滚动公告
Route::post("getscrollnews","News\GetScrollNews");



