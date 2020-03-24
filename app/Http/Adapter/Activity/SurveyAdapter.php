<?php
/**
 * 用户调查的创建适配器
 *
 * @author  老拐<geyunfei@kakamf.com>
 * @version 1.0
 * @date    Nov 6th,2017
 */
namespace App\Http\Adapter\Activity;

use App\Http\Adapter\IAdapter;

/**
 * 类定义
 */
class SUrveyAdapter extends IAdapter
{
    protected $mapArray = [
        "code"=>"survey_invcode"
        ,"name"=>"survey_name"
        ,"mobile"=>"survey_mobile"
        ,"city"=>"survey_city"
        ,"birth"=>"survey_birth"
        ,"income"=>"survey_income"
        ,"idpre"=>"survey_idpre"
        ,"idno"=>"survey_idno"
    ];

}