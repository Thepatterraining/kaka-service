<?php

use Illuminate\Http\Request;
//api/v2/admin/product

/*************************    交易   ***********************************/
//挂买单
Route::post("transbuy","Trade\TranactionBuy")->middleware('chkstatus')->middleware('chkidno')->middleware('chkpaypwd')->middleware('checkaccount');
//购买卖单
Route::post("transbuysell","Trade\TranactionBuySell")->middleware('chkstatus')->middleware('chkidno')->middleware('chkpaypwd')->middleware('checkaccount');
//撤销买单
Route::post("revoketransbuy","Trade\RevokeTransactionBuy")->middleware('checkaccount');
//挂卖单
Route::post("transsell","Trade\TranactionSell")->middleware('chkstatus')->middleware('chkidno')->middleware('chkpaypwd')->middleware('checkaccount');
//撤销卖单
Route::post("revoketranssell","Trade\RevekeTransactionSell")->middleware('checkaccount');

//查询未成交列表
Route::post("getopenorders","Trade\GetOpenOrders");

//查询已成交列表
Route::post("getcloseorders","Trade\GetCloseOrders");

//撤销挂单
Route::post("revoketrans","Trade\RevokeTransaction")->middleware('checkaccount');

