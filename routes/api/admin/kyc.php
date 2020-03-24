<?php

use Illuminate\Http\Request;

//查询地址列表
Route::post("getcoinaddress","Admin\Kyc\GetCoinAddress");

//审核地址
Route::post("confirmcoinaddr","Admin\Kyc\ConfirmCoinAddress");

 