<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Auth\AccessToken;
use App\Data\Sys\LoginLogData;

class UpdateLoginLogController extends Controller
{
    private $ipAddress = '';
    private $latitude = 0;
    private $longitude = 0;
    private $deviceType = '';
    private $deviceSystem = '';
    private $deviceBrand = '';
    
    /**
     *
     * @api {post} token/auth/updateloginlog 更新登陆日志
     * @apiName updateloginlog
     * @apiGroup User
     * @apiVersion 0.0.1
     *
     * @apiParam {string} ip_address ip 可选
     * @apiParam {float} latitude 纬度 可选
     * @apiParam {float} longitude  经度 可选
     * @apiParam {string} device_type 设备型号 可选
     * @apiParam {string} device_system 设备操作系统 (版本) 可选
     * @apiParam {string} device_brand 设备品牌 可选
     *
     * @apiParamExample {json} Request-Example:
     * {
     *      ip_address : 127.0.0.1
     *      latitude   : 0.986
     *      longitude  : 0.986
     *      device_type  : ""
     *      device_system  : ""
     *      device_brand  : ""
     * }
     *
     * @apiSuccess {number} code 状态码 = 0 成功
     * @apiSuccess {string} msg 调用成功
     * @apiSuccess {datetime} datetime 调用时间
     * @apiSuccess {object} data 返回数据
     *
     * @apiSuccessExample {json} Success-Response:
     *
     * {
     *      code : 0,
     *      msg  : 调用成功,
     *      datetime : ,
     *      data : null
     * }
     */
    protected function run()
    {
        if ($this->request->has("ipAddress")) {
            $this->ipAddress = $this->request->input("ipAddress");
        }
        if ($this->request->has("latitude")) {
            $this->latitude = $this->request->input("latitude");
        }
        if ($this->request->has("longitude")) {
            $this->longitude = $this->request->input("longitude");
        }
        if ($this->request->has("device_type")) {
            $this->deviceType = $this->request->input("device_type");
        }
        if ($this->request->has("device_system")) {
            $this->deviceSystem = $this->request->input("device_system");
        }
        if ($this->request->has("device_brand")) {
            $this->deviceBrand = $this->request->input("device_brand");
        }

        //更新登陆log
        $logDataFac = new LoginLogData();
        $logDataFac->updateLog($this->ipAddress, $this->latitude, $this->longitude, $this->deviceType, $this->deviceSystem, $this->deviceBrand);

        return $this->Success();
    }
}
