<?php

use Illuminate\Http\Request;

//查询所有用户组
Route::post("getauthgroups","Auth\GetAuthGroups");

//查用户组详细
Route::post("getauthgroup","Auth\GetAuthGroup");

//添加用户组
Route::post("createauthgroup","Auth\CreateAuthGroup");

//删除用户组
Route::post("deleteauthgroup","Auth\DeleteAuthGroup");

//修改用户组
Route::post("saveauthgroup","Auth\SaveAuthGroup");

//添加用户到用户组
Route::post("addauthgroupitem","Admin\AuthGroup\AddAuthGroupItem");

//删除用户组的用户
Route::post("deleteauthgroupitem","Admin\AuthGroup\DeleteAuthGroupItem");

//查询用户组的所有用户
Route::post("getauthgroupitems","Admin\AuthGroup\GetAuthGroupItems");

//查询用户的所有权限
Route::post("getuserauths","Admin\Auth\GetUserAuths");

//查询用户的所有用户组
Route::post("getuserauthgroups","Admin\AuthGroup\GetUserGroups");

//添加权限到用户组
Route::post("addauthitem","Admin\Auth\AddAuthItem");

//移除权限从用户组
Route::post("deleteauthitem","Admin\Auth\DeleteAuthItem");

//查询权限列表
Route::post("getauths","Admin\Auth\GetAuths");

//添加权限
Route::post("createauth","Admin\Auth\CreateAuth");

//删除权限
Route::post("deleteauth","Admin\Auth\DeleteAuth");

//查询权限详细
Route::post("getauth","Admin\Auth\GetAuth");

//修改权限详细
Route::post("saveauth","Admin\Auth\SaveAuth");

//查询用户菜单
Route::post("getusermenus","Admin\Auth\GetUserMenus");
