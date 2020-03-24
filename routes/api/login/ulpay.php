<?php

use Illuminate\Http\Request;
//api/v2/admin/ulpay

//充值
Route::post("recharge","ThirdPayment\UlPayRecharge")->middleware('chkstatus')->middleware('chkidno');

//充值确认
Route::post("rechargeconfirm","ThirdPayment\UlPayRechargeConfirm")->middleware('chkstatus')->middleware('chkidno')->middleware('chkpaypwd')->middleware('checkaccount');

//发短信
Route::post("rechargesms","ThirdPayment\UlPayRechargeSms")->middleware('chkstatus')->middleware('chkidno');

//购买
Route::post("ulpayment","ThirdPayment\UlPayment")->middleware('chkstatus')->middleware('chkidno');

//购买确认
Route::post("ulpaymentconfirm","ThirdPayment\UlPaymentConfirm")->middleware('chkstatus')->middleware('chkidno')->middleware('chkpaypwd')->middleware('checkaccount');
