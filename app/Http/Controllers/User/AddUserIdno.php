<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\User\UserData;
use App\Http\Adapter\User\UserAdapter;
use App\Data\Sys\ErrorData;
use App\Data\API\AliAPI\API;

class AddUserIdno extends Controller
{

    protected $validateArray=[
        "data"=>"required|array",
        "data.idno"=>"required|idno|unique:sys_user,user_idno",
        "data.name"=>"required",
    ];

    protected $validateMsg = [
        "data.required"=>"请输入data",
        "data.array"=>"data必须是一个数组",
        "data.idno.required"=>"请输入身份证号",
        "data.idno.unique"=>"该身份证号已验证",
        "data.name.required"=>"请输入姓名",
        "data.idno.unique"=>"该身份证号码已注册！",
    ];

     /**
      * @api {post} user/adduseridno 初始化身份证号
      * @apiName 初始化身份证号
      * @apiGroup User
      * @apiVersion 0.0.1
      *
      * @apiParam {string} data.name 姓名
      * @apiParam {string} data.idno 身份证号
      *
      * @apiParamExample {json} Request-Example:
      *  {
      *      data : {
      *          name : 章三
      *          idno : 1100**********3564
      *      }
      *
      *  }
      *
      * @apiSuccess {number} code 状态码 = 0 成功
      * @apiSuccess {string} msg 调用成功
      * @apiSuccess {datetime} datetime 调用时间
      * @apiSuccess {object} data 返回数据
      *
      * @apiSuccessExample {json} Success-Response:
      *  {
      *      code : 0,
      *      msg  : '调用成功',
      *      datetime : '2017-05-17 14:15:59',
      *      data : {
      *              "loginid" => "1EC3C748-017F-6373-CA36-537EB2A7116C"  登陆id
      *               "nickname" => "" 昵称
      *               "name" => "周涛" 姓名
      *               "idno" => "4211**********816" 身份证号
      *               "mobile" => "132******444" 手机号
      *               "status" => {  状态
      *                  "no" => "US01"
      *                  "name" => "正常"
      *               }
      *               "lastlogin" => "2017-05-31 11:13:25" 最后登陆时间
      *               "with" => 1 提现次数
      *               "withdate" => "2017-05-19 23:11:19" 最后提现时间
      *               "headimgurl" => "/upload/touxiang/baiyang.jpg" 头像
      *               "dream1" => "" 梦想1
      *               "dream2" => "" 梦想2
      *               "checkidno" => 1  是否设置身份证号 1 已设置 0 没有设置
      *          }
      *  }
      */
    public function run()
    {
        $request = $this->request->all();

        $data = new UserData();
        $adapter = new UserAdapter();
        //验证身份证号码是否为空
        $idnoIsEmpty = $data->idnoIsEmpty();
        $idno = $data->getUserIdno($this->session->userid);
        if ($idnoIsEmpty === true && !empty($idno)) {
            return $this->Error(ErrorData::$USER_IDNO_REQUIRED);
        }

        //同盾查看是否匹配
        $name = $this->request->input('data.name');
        $idno = $this->request->input('data.idno');
        $idnoCheck = $data->tongDunApi($name, $idno);
        if ($idnoCheck === false) {
            return $this->Error(ErrorData::$USER_IDNO_ERROR);
        }
        //修改支付密码
        if ($idnoIsEmpty === false) {
            //为空，可以增加
            $userInfo = $adapter->getData($this->request);
            $userInfo = array_add($userInfo, 'checkidno', 1);
            $headImg = $data->getUserConstellationHeadImg($idno);
            $userInfo = array_add($userInfo, 'headimgurl', $headImg);

            //更新身份证信息
            // $idnoInfo = API::QueryIDInfo($idno);
            // if (!empty($idnoInfo) && is_object($idnoInfo)) {
            //     $userInfo = array_add($userInfo, 'idProvince', $idnoInfo->province);
            //     $userInfo = array_add($userInfo, 'idCity', $idnoInfo->city);
            //     $userInfo = array_add($userInfo, 'idTown', $idnoInfo->town);
            //     $userInfo = array_add($userInfo, 'idArea', $idnoInfo->area);
            //     $userInfo = array_add($userInfo, 'sex', $idnoInfo->sex);
            //     $userInfo = array_add($userInfo, 'idBirth', $data->strToDate($idnoInfo->birth));
            // }

            $userModel = $data->getUser($this->session->userid);
            $adapter->saveToModel(false, $userInfo, $userModel);
            $data->save($userModel);
            $userInfo = $adapter->getDataContract($userModel);
            return $this->Success($userInfo);
        } elseif ($idnoIsEmpty == true && $idnoIsEmpty !== true) {
            return $this->Error($idnoIsEmpty);
        } elseif ($idnoIsEmpty === true) {
            return $this->Error(ErrorData::$USER_IDNO_REQUIRED);
        }
    }
}
