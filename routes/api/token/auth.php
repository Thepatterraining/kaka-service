<?php

use Illuminate\Http\Request;
//api/v2/admin/product

//查询用户信息
Route::post("getuser","Auth\GetUser");

//更新登陆日志
Route::post("updateloginlog","Auth\UpdateLoginLogController");

//kyc认证地址
Route::post("checkcoinaddr","Kyc\CheckCoinAddr")->middleware("chkmobileverify");

//kyc认证地址查询
Route::post("getcoinaddr","Kyc\GetCoinAddr");

//kyc认证地址状态修改
Route::post("savecoinaddr","Kyc\SaveCoinAddr");

//kyc图片上传
Route::post("upload","Kyc\Resource\Upload");

