<?php

use Illuminate\Http\Request;
//api/v2/admin/product
//查询所有预购单
Route::post("getpreorders","Admin\GetPreOrders");

//审核产品
Route::post("audit","Product\AdminAuditProduct");

//修改产品信息
Route::post("save","Product\AdminSaveProduct");

//终止产品信息
Route::post("end","Product\AdminEndProduct");


//添加产品价格
Route::post("addtrend","Product\AddTrend");
//查询产品价格详细
Route::post("product/gettrendinfo","Product\GetTrendInfo");
//修改产品价格
Route::post("product/savetrend","Product\SaveTrend");
//删除产品价格
Route::post("product/deletetrend","Product\DeleteTrend")->middleware('admin');
//查询产品价格列表
Route::post("product/gettrendlist","Product\GetTrendList")->middleware('admin');

//查询用户产品列表
Route::post("list","Product\GetAdminProductInfoList");