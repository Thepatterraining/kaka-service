<?php

use Illuminate\Http\Request;
//api/v2/admin/product

//个人中心查询参数
Route::post("getassetsquantity","User\GetUserAssetsQuantity");

//查询用户代币余额
Route::post("getusercoin","User\GetUserCoin");

//领取活动奖励
Route::post("activitygetvoucher","User\ActivityGetVoucher");


//得到当前活动是否达到活动要求
Route::post("activitysteps","User\ActivitysTeps");

//查询用户代币余额
Route::post("getuserpresellcoin","User\GetUserPreSellCoin");

