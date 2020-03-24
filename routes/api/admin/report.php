<?php

use Illuminate\Http\Request;
/********************** 报表 *************************/
//日常
Route::post("rmakedayreport","Report\MakeDayReport");
//获取用户日报列表
Route::post("day/user","Report\GetReportDayList");
//获取用户时报列表
Route::post("hour/user","Report\GetReportHourList");

//用户返佣日报

Route::post("day/userrb","Report\GetUserrbReportDayList");

//发起返佣
Route::post("createrebate","Report\CreateRebate");


//审核返佣
Route::post("confirmrebate","Report\ConfirmRebate");

//用户代币日报

Route::post("day/usercoin","Report\GetUserCoinReportDayList");


Route::post("makereport","Report\MakeReport");

//用户交易日报
Route::post("day/usertrade","Report\GetTradeReportDayList");

//用户提现日报
Route::post("day/userwithdrawal","Report\GetWithdrawalReportDayList");

//用户充值日报
Route::post("day/userrecharge","Report\GetRechargeReportDayList");

//用户充值渠道日报
Route::post("day/userrechargeitem","Report\GetRechargeItemReportDayList");

//每日汇总数据
// Route::post("day/settlementlist","Report\GetReportSettlementDayList");
