<?php
namespace App\Data\Sys;

use App\Data\IDataFactory;
use Illuminate\Support\Facades\Redis;
use \Illuminate\Support\Facades\Log;
use App\Data\Sys\ErrorData;
use App\Data\Cash\RechargeData;
use App\Data\User\UserData;

class SendSmsData extends IDatafactory
{

    public static $SEND_SMS_TYPE_REG = 'SLT01';
    public static $SEND_SMS_TYPE_LOGIN = 'SLT08';
    const SEND_SMS_TYPE_BIND_CARD = 'SLT04';
    const SEND_SMS_TYPE_SAVE_USER = 'SLT05';
    const SEND_SMS_TYPE_RECHARGE = 'SLT07';
    const SEND_SMS_TYPE_WITHDRAWAL = 'SLT09';
    const SEND_SMS_TYPE_BONUS = 'SLT10';

    /**
     * 阿里大雨
     *
     * @param   $phone 手机号,用户输入的手机号
     * @param   $name 短信签名,阿里大鱼申请的短信签名的名字
     * @param   $content 替换短信模板中的变量,JSON字符串格式,所有值都是字符串,不能有整形
     * @param   $code 阿里大鱼申请的短信模板编号
     * @param   Sms                                                                                                 $sms
     * @return  \Iscloudx\AlibigfishSdk\ResultSet|mixed|\SimpleXMLElement
     * @author  zhoutao
     * @version 0.1
     */
    public function sendCode($phone, $type, $sms)
    {
        //查到类型
        $data = new DictionaryData();
        $dic = $data->getDictionary('sms_code', $type);
        $oper = $dic->dic_name;
        //发送短信
        $smsLog = new SmsLogData();
        $name = '咔咔买房';
        $verfy=rand(100000, 999999);
        $content = "{oper:'$oper',code:'$verfy'}";
        $code = "SMS_38915003";
        $semdRes = $smsLog->sendSms($phone, $name, $content, $code, $sms);
        $res['phone'] = $phone;
        $res['verfy'] = $verfy;
        //调用返回
        $res['res'] = $this->sendMsgResult($phone, $type, $verfy, $semdRes);
        return $res;
    }

    /**
     * 返回数据
     *
     * @param   null $_resp 阿里大雨返回值
     * @return  bool
     * @author  zhoutao
     * @version 0.1
     * 
     * 增加判断属性是否存在
     * @author  zhoutao
     * @date    2017.11.15
     */
    private function sendMsgResult($phone, $type, $code, $_resp = null)
    {
        $smsLog = new SmsLogData();
        // info(json_encode($_resp, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK));
        if (property_exists($_resp, 'result') && $_resp->result->success && $_resp->result->err_code == 0) {
            $smsLog->addLog($phone, $type, 'true', '发送成功,验证码：' . $code);
            return true;
        } elseif ($_resp->code || $_resp->msg == "Remote service error") {
            $subCode = property_exists($_resp, 'sub_code') ? $_resp->sub_code : '';
            $subMsg = property_exists($_resp, 'sub_msg') ? $_resp->sub_msg : '';
            $smsLog->addLog($phone, $type, 'false', $subCode . '====' . $subMsg);
            return false;
        } else {
            $smsLog->addLog($phone, $type, 'false', '发送失败');
            return false;
        }
    }

    /**
     * 判断验证码是否正确
     *
     * @param   $phone 手机号
     * @param   $verify 验证码
     * @return  bool
     * @author  zhoutao
     * @version 0.1
     */
    public function isVerfy($phone, $verify)
    {
        if (Redis::exists($phone) && Redis::get($phone) == $verify) {
            Redis::set($phone, 0);
            return true;
        }
        return false;
    }

    public function isVerfyCode($phone, $verify)
    {
        // info('手机验证码'.Redis::get($phone));
        if (Redis::exists($phone) && Redis::get($phone) == $verify) {
            return true;
        }
        return false;
    }
    /**
     * 发送通知
     *
     * @param   $phone      手机号
     * @param   $type       通知类型
     * @param   $no         单据号
     * @param   $userName   用户名
     * @param   $money      提现金额
     * @param   $user       余额
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
    public function sendNotify($phone, $type, $sms, $no, $userName, $money, $user)
    {
        //查到类型
        $data = new DictionaryData();
        $dic = $data->getDictionary('sms_code', $type);
        $oper = $dic->dic_name;
        
        //发送短信
        $smsLog = new SmsLogData();
        $userData=new UserData();
        $name = "咔咔买房";
        $time=date("Y-m-d H:i");
        $content = "{time:'$time',oper:'$oper',money:'$money',name:'$userName',user:'$user'}";
        $code = "SMS_103330031";
        $sendRes = $smsLog->sendSms($phone, $name, $content, $code, $sms);
        $res['phone'] = $phone;
        //调用返回
        $res['res'] = $this->sendNotifyMsgResult($phone, $type, $no, $oper, $sendRes);
        return $res;
    }
     /**
      * 返回充值返现通知数据
      *
      * @param   null $_resp 阿里大雨返回值
      * @return  bool
      * @author  liu
      * @version 0.1
      */
    private function sendNotifyMsgResult($phone, $type, $no, $noType, $_resp = null)
    {
        $smsLog = new SmsLogData();
        // info(json_encode($_resp, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK));
        if (property_exists($_resp, 'result') && $_resp->result->success && $_resp->result->err_code == 0) {
            $smsLog->addLog($phone, $type, 'true', '发送成功,发送原因：' . $noType.' 单据号:'.$no);
            return true;
        } elseif ($_resp->code || $_resp->msg == "Remote service error") {
            $subCode = property_exists($_resp, 'sub_code') ? $_resp->sub_code : '';
            $subMsg = property_exists($_resp, 'sub_msg') ? $_resp->sub_msg : '';
            $smsLog->addLog($phone, $type, 'false', $subCode . '====' . $subMsg);
            return false;
        } else {
            $smsLog->addLog($phone, $type, 'false', '发送失败');
            return false;
        }
    }
}
