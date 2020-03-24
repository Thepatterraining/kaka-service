<?php
// api/withoutmid/queue

/*************************    队列   ***********************************/
//队列信息回调
Route::post("callback","App\Http\Controllers\Queue\CallbackQueue");

//获取队列
Route::post("getqueue","App\Http\Controllers\Queue\GetQueue");

//增加队列，同时添加路由
Route::post("addqueue","App\Http\Controllers\Queue\AddQueue");

//删除队列
Route::post("deletequeue","App\Http\Controllers\Queue\DeleteQueue");

//获取路由相关队列列表
Route::post("getqueuelist","App\Http\Controllers\Queue\GetQueueList");

//获取队列列表
Route::post("getallqueuelist","App\Http\Controllers\Queue\GetAllQueueList");

//获取路由信息
Route::post("deleteexchange","App\Http\Controllers\Queue\DeleteExchange");

//获取路由列表
Route::post("getexchangelist","App\Http\Controllers\Queue\GetExchangeList");