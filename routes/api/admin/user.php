<?php

use Illuminate\Http\Request;

//查询所有微信用户
Route::post("getvpusers","Admin\GetVpUsers");

//查询所有用户优惠券
Route::post("getusercoupons","Admin\GetUserCoupons");

//使用邀请码查询用户信息
Route::post("codegetuser","Admin\CodeGetUser");

//创建冻结
Route::post("createfreezondoc","Admin\User\CreateCashFreezonDoc");

//创建解冻
Route::post("createunfreezondoc","Admin\User\CreateUnCashFreezonDoc");

//审核冻结／解冻
Route::post("confirmfreezondoc","Admin\User\ConfirmCashFreezonDoc");

//查询冻结列表
Route::post("getfreezondocs","Admin\User\GetCashFreezonDocs");

//清算
Route::post("clearUserAccount", "User\ClearUserAccount");

