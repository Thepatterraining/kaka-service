<?php

use Illuminate\Http\Request;
//api/v2/admin/product

//查询第三方支付是否可用信息
Route::post("get3rdpayconfig","Auth\Get3rdpayConfig");

Route::post("gateway","ThirdPayment\RequirePayment")->middleware("login");
Route::post("methods","ThirdPayment\GetPayMethods")->middleware("login");
Route::post("prepare","ThirdPayment\PrepareJsPay")->middleware("login");
Route::post("recharge","ThirdPayment\PrepareJsRecharge")->middleware("login");
Route::post("confirm/","ThirdPayment\ConfirmPayment");

Route::post("confirm/{m}","ThirdPayment\ConfirmPayment");


Route::post("confirmjs/","ThirdPayment\ComfirmJsPayment");

Route::post("confirmjs/{m}","ThirdPayment\ComfirmJsPayment");