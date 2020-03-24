<?php
namespace App\Data\Sys;

use App\Data\IDataFactory;

class SmsLogData extends IDatafactory
{
    public static $USER_NOT_FOUND = 801001;

    protected $modelclass = 'App\Model\Sys\SmsLog';

    /**
     * 添加短信日志记录
     *
     * @param   $phone 手机号
     * @param   $type 类型
     * @param   $status 发送状态
     * @author  zhoutao
     * @version 0.1
     */
    public function addLog($phone, $type, $status, $body)
    {
        $model= $this->newitem();
        $model->mobile = $phone;
        $model->sms_type = $type;
        $model->sms_status = $status;
        $model->sms_body = $body;
        return $model->save();
    }

    public function sendSms($phone, $name, $content, $code, $sms)
    {
        $model = $this->newitem();
        return $model->sendSms($phone, $name, $content, $code, $sms);
    }
}
