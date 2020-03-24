<?php

use Illuminate\Http\Request;

//增加国家
Route::post("addcountry","Admin\Region\AddCountry");

//增加省
Route::post("addprovince","Admin\Region\AddProvince");

//增加城市
Route::post("addcity","Admin\Region\AddCity");

//增加区
Route::post("adddistrict","Admin\Region\AddDistrict");

//增加线路
Route::post("addsubwayline","Admin\Region\AddSubwayline");

//增加地铁站
Route::post("addsubwaystation","Admin\Region\AddSubwaystation");

//删除国家
Route::post("deletecountry","Admin\Region\DeleteCountry");

//删除省
Route::post("deleteprovince","Admin\Region\DeleteProvince");

//删除城市
Route::post("deletecity","Admin\Region\DeleteCity");

//删除区
Route::post("deletedistrict","Admin\Region\DeleteDistrict");

//删除线路
Route::post("deletesubwayline","Admin\Region\DeleteSubwayline");

//删除地铁站
Route::post("deletesubwaystation","Admin\Region\DeleteSubwaystation");


//修改国家
Route::post("savecountry","Admin\Region\SaveCountry");

//修改省
Route::post("saveprovince","Admin\Region\SaveProvince");

//修改城市
Route::post("savecity","Admin\Region\SaveCity");

//修改区
Route::post("savedistrict","Admin\Region\SaveDistrict");

//修改线路
Route::post("savesubwayline","Admin\Region\SaveSubwayline");

//修改地铁站
Route::post("savesubwaystation","Admin\Region\SaveSubwaystation");


//查询国家
Route::post("getcountry","Admin\Region\GetCountry");

//查询省
Route::post("getprovince","Admin\Region\GetProvince");

//查询城市
Route::post("getcity","Admin\Region\GetCity");

//查询区
Route::post("getdistrict","Admin\Region\GetDistrict");

//查询线路
Route::post("getsubwayline","Admin\Region\GetSubwayline");

//查询地铁站
Route::post("getsubwaystation","Admin\Region\GetSubwaystation");

//查询国家列表
Route::post("getcountris","Admin\Region\GetCountris");

//查询省列表
Route::post("getprovinces","Admin\Region\GetProvinces");

//查询城市列表
Route::post("getcitis","Admin\Region\GetCitis");

//查询区列表
Route::post("getdistricts","Admin\Region\GetDistricts");

//查询线路列表
Route::post("getsubwaylines","Admin\Region\GetSubwaylines");

//查询地铁站列表
Route::post("getsubwaystations","Admin\Region\GetSubwaystations");
