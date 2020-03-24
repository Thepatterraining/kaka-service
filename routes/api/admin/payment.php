<?php

use Illuminate\Http\Request;

Route::post("incomedoclist","Admin\ThirdPayment\IncomeDocList");///->middleware("admin");
Route::post("incomedoccheck","Admin\ThirdPayment\IncomeDocCheck");///->middleware("admin"); //api/v2/admin/payment
//入帐拒绝
Route::post("incomedoccheckrefuse","Admin\ThirdPayment\IncomeDocCheckRefuse");