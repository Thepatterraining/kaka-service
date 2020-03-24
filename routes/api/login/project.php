<?php

use Illuminate\Http\Request;
//api/v2/admin/product

//购买时候 查询合同
Route::post("getusufruct","Item\GetItemUsufruct");


//在现金账单 查询合同
Route::post("getcashbillusufruct","User\GetUserUsufruct");
