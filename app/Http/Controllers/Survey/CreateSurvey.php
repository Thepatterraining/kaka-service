<?php
/**
 * 创建用户调查的controller 
 *
 * @author  老拐<geyunfei@kakamf.com>
 * @version 1.0
 * @date    Nov 6th,2017
 */
namespace App\Http\Controllers\Survey;

use App\Http\Controllers\Controller;
use App\Http\Adapter\Activity\SurveyAdapter;
use App\Data\Activity\SurveyData;

/**
 * 创建类
 *
 * @author 老拐<geyunfei@kakamf.com>
 */
class CreateSurvey extends Controller
{

    protected function run()
    {

        $data = new SurveyData();
        $adapter = new SurveyAdapter;
        $model = $data->newitem();
        $info = $adapter->getData($this->request);
        $adapter->saveToModel(false, $info, $model);
        $data->create($model);

        return $this->Success();
    }

}