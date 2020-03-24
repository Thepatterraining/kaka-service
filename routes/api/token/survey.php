<?php
/**
 * 用户调查问券相关的路由配置
 */
use Illuminate\Http\Request;

Route::post("create", "Survey\CreateSurvey");