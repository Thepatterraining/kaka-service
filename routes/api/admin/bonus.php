<?php

use Illuminate\Http\Request;

//发起分红
Route::post("createBonus","Admin\AddBonus");

//审核分红
Route::post("confirmBonus","Admin\ConfirmBonus");


//查询分红表列表
Route::post("getbonuslist","Admin\Bonus\GetBonusList");


Route::post("getbonusitemlist","Admin\Bonus\GetBonusItemList");

 