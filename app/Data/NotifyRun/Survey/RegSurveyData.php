<?php
namespace App\Data\NotifyRun\Survey;

use App\Data\Notify\INotifyDefault;
use App\Data\Activity\SurveyData;

/**
 * 注册时候 survey 的回调
 * @author zhoutao
 * @date 2017.11.22
 */
class RegSurveyData implements INotifyDefault
{
    /**
     * 用户注册以后，如果存在，更新用户id
     * @author zhoutao
     * @date 2017.11.22
     */
    public function notifycreateddefaultrun($data)
    {
        $mobile = $data['user_mobile'];
        $userid = $data['id'];

        $data = new SurveyData;
        $where['survey_mobile'] = $mobile;
        $survey = $data->find($where);
        if (!empty($survey)) {
            //更新用户id
            $survey->survey_reg = 1;
            $survey->survey_regid = $userid;
            $data->save($survey);
        }
    }
    
    public function notifysaveddefaultrun($data) {}
    public function notifydeleteddefaultrun($data) {}
}