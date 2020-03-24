<?php
namespace App\Data\Sys;

use App\Data\IDataFactory;
use App\Data\API\AliAPI\API;

class LoginLogData extends IDatafactory
{
    public static $USER_NOT_FOUND = 801001;

    protected $modelclass = 'App\Model\Sys\LoginLog';

    /**
     * 创建登陆log
     *
     * @author zhoutao
     * @date   2017.9.27
     */
    public function addLog()
    {

        $model = $this->modelclass;

        $where['login_token'] = $this->session->token;
        $log = $model::where($where)->orderBy('login_time', 'desc')->first();
        if (!empty($log)) {
            $log->user_id = $this->session->userid;
            $log->login_token = $this->session->token;
            $log->login_type = "UL01";
            $log->login_time = date('Y-m-d H:i:s');
            if (array_key_exists("REMOTE_ADDR", $_SERVER)==false) {
                $_SERVER['REMOTE_ADDR']="UNKNOWN";
            }
            $log->login_add = $_SERVER['REMOTE_ADDR'];
            ;
            $log->login_mac = $_SERVER['REMOTE_ADDR'];
            $log->login_ip = $_SERVER['REMOTE_ADDR'];
            $this->save($log);
        } 
    }

    /**
     * 更新登陆log
     *
     * @author zhoutao
     * @date   2017.9.27
     * 
     * 增加了app信息
     * @param  $appid appid
     * @author zhoutao
     * @date   2017.11.7
     */
    public function createLog($appid)
    {
        $applicationData = new ApplicationData;
        $app = $applicationData->getByNo($appid);

        $log = $this->newitem();
        $log->user_id = $this->session->userid;
        $log->login_token = $this->session->token;
        $log->login_type = "UL01";
        $log->login_time = date('Y-m-d H:i:s');
        if (array_key_exists("REMOTE_ADDR", $_SERVER)==false) {
            $_SERVER['REMOTE_ADDR']="UNKNOWN";
        }
        $log->login_add = $_SERVER['REMOTE_ADDR'];
        ;
        $log->login_mac = $_SERVER['REMOTE_ADDR'];
        $log->login_ip = $_SERVER['REMOTE_ADDR'];
        $log->login_appid = $appid;
        if (!empty($app)) {
            $log->login_appname = $app->app_name;
            $log->login_appguid = $app->id;
        }
        
        $this->create($log);
    }

    /**
     * 更新登陆log
     *
     * @param  $ipAddress ip
     * @param  $latitude 纬度
     * @param  $longitude 经度
     * @param  $deviceType 设备型号
     * @param  $deviceSystem 设备操作系统 (版本)
     * @param  $deviceBrand 设备品牌
     * @author zhoutao
     * @date   2017.9.27
     */
    public function updateLog($ipAddress, $latitude, $longitude, $deviceType, $deviceSystem, $deviceBrand)
    {
        $model = $this->modelclass;

        $where['login_token'] = $this->session->token;
        $log = $model::where($where)->orderBy('login_time', 'desc')->first();
        if (!empty($log)) {
            // $ipInfo = API::QueryIpInfo($ipAddress);
            // if (!empty($ipInfo) && is_object($ipInfo)) {
            //     $log->ip_area = $ipInfo->area;
            //     $log->ip_city = $ipInfo->city;
            //     $log->ip_country = $ipInfo->country;
            //     $log->ip_isp = $ipInfo->isp;
            //     $log->ip_region = $ipInfo->region;
            // }
            $log->login_ip = $ipAddress;
            $log->login_latitude = $latitude;
            $log->login_longitude = $longitude;
            $log->login_device_type = $deviceType;
            $log->login_device_system = $deviceSystem;
            $log->login_device_brand = $deviceBrand;
            $this->save($log);
        } 
    }
}
