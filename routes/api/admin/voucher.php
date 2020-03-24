<?php

use Illuminate\Http\Request;

//查询优惠券每日使用情况
Route::post("day/getvoucher","Admin\GetVoucherDayList");
