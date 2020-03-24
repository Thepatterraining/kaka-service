<?php

use Illuminate\Http\Request;
Route::post("addscheduledefine","Admin\Schedule\AddScheduleDefine");
Route::post("savescheduledefine","Admin\Schedule\SaveScheduleDefine");
Route::post("deletescheduledefine","Admin\Schedule\DeleteScheduleDefine");
Route::post("queryscheduledefine","Admin\Schedule\GetScheduleDefineList");

Route::post("queryscheduleitem","Admin\Schedule\GetScheduleItemList");