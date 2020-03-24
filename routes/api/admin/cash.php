<?php

use Illuminate\Http\Request;

//查询所有平台账户
Route::post("getsysaccounts","Admin\GetSysCashAccounts");

//查询所有平台账户
Route::post("getbankaccount","Admin\GetCashBanks");

//创建内部转账
Route::post("createcashjournaldoc","Admin\Sys\CreateCashJournalDoc");

//审核内部转账
Route::post("confirmcashjournaldoc","Admin\Sys\ConfirmCashJournalDoc");

//查询内部转账列表
Route::post("getcashjournaldocs","Admin\Sys\GetCashJournalDocs");

//创建外部转账
Route::post("createjournaldoc","Admin\Cash\CreateJournalDoc");

//审核外部转账
Route::post("confirmjournaldoc","Admin\Cash\ConfirmJournalDoc");

//查询外部转账列表
Route::post("getjournaldocs","Admin\Cash\GetJournalDocs");


