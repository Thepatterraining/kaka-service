<?php

use Illuminate\Http\Request;
//api/v2/admin/bank

//绑卡
Route::post("bindbankcard","User\BindUserBankCard")->middleware('chkmobileverify');
