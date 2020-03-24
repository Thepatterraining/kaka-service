<?php

use Illuminate\Http\Request;

//创建返现
Route::post("createpayuser","Admin\CreatePayUser");


//审核返现
Route::post("confirmpayuser","Admin\ConfirmPayUser");

//查询返现
Route::post("getpayusers","Admin\GetPayUsers");


