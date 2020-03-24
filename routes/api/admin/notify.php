<?php
use Illuminate\Http\Request;

//获得通知组信息
Route::post("getgroup","Admin\Notify\GetNotifyGroupInfo");
//获得通知组列表
Route::post("listgroup","Admin\Notify\GetNotifyGroupList");
//创建通知组
Route::post("creategroup","Admin\Notify\CreateNotifyGroup");
//更新通知组
Route::post("updategroup","Admin\Notify\SaveNotifyGroup");
//删除通知组
Route::post("deletegroup","Admin\Notify\DeleteNotifyGroup");
//增加通知组成员
Route::post("addtogroup","Admin\Notify\CreateNotifyGroupMember");
//删除通知组成员
Route::post("removefromgroup","Admin\Notify\DeleteNotifyGroupMember");
//得到通知组成员
Route::post("getgroupmembers","Admin\Notify\GetNotifyGroupMemberInfo");
//获得通知定义信息
Route::post("getnotifydefine","Admin\Notify\GetNotifyDefineList");
//获得事件定义信息
Route::post("getdefine","Admin\Notify\GetDefineList");
//创建通知定义
Route::post("createdefine","Admin\Notify\CreateNotifyDefine");
//创建事件定义
Route::post("createeventdefine","Admin\Notify\CreateDefine");
//更新通知定义
Route::post("updatedefine","Admin\Notify\SaveNotifyDefine");
//更新通知定义
Route::post("updateeventdefine","Admin\Notify\SaveDefine");
//删除通知定义
Route::post("deletedefine","Admin\Notify\DeleteNotifyDefine");
//删除事件定义
Route::post("deleteeventdefine","Admin\Notify\DeleteDefine");
//得到通知组成员
Route::post("getdefineinfo","Admin\Notify\GetDefineInfo");
//得到通知组成员
Route::post("getnotifydefineinfo","Admin\Notify\GetNotifyDefineInfo");