<?php

use Illuminate\Http\Request;

//修改项目指导价
Route::post("saveguideprice","Admin\SaveItemGuidePrice");



//查询所有微信用户
Route::post("getinfoitemdefines","Admin\Project\GetInfoItemDefines");

//查询所有微信用户
Route::post("converttypeinputs","Admin\Project\ConvertTypeInputs");


