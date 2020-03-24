<?php

use Illuminate\Http\Request;
//api/v2/admin/product

//查询趋势曲线
Route::post("getcurves","Item\GetProjectCurves");

//查询地图坐标
Route::post("getcoordinates","Item\GetItemCoordinates");

//查询项目列表
Route::post("getprojects","Item\GetItems");

//插入房源
Route::post("createhouse","Project\CreateHouse");

//查询项目分红列表
Route::post("getbonus","Item\GetBonus");

//查询项目列表
Route::post("getprojectlist","Project\GetProjects");

//查询项目评分
Route::post("getprojectscore","Project\GetProjectScore");

//查询项目详情
Route::post("getproject","Project\GetProject");

//查询项目相关资源
Route::post("getprojectresource","Project\GetProjectResource");

//查询项目相关资源
Route::post("getresource","Project\GetResource");

//查询项目租赁合同
Route::post("getcontracts","Project\GetContracts");



