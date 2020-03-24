<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\User\UserData;
use App\Http\Adapter\User\UserAdapter;
use App\Data\Sys\ErrorData;
use App\Data\API\AliAPI\API;

class StorageInfo extends Controller
{

    protected $validateArray=array(
        "data.name"=>"required",
        "paypwd"=>"required|paypwd",
        "data.idno"=>"required|idno|unique:sys_user,user_idno"
    );

    protected $validateMsg = [
        "data.name.required"=>"请输入姓名",
        "data.idno.required"=>"请输入身份证号码",
        "paypwd.required"=>"请输入支付密码",
        "data.idno.unique"=>"该身份证号码已注册！",
    ];

    /**
     * 更新用户支付密码，姓名和身份证号
     *
     * @param   $paypwd 支付密码
     * @param   $data.name 姓名
     * @param   $data.idno 身份证号
     * @author  zhoutao
     * @version 0.1
     * @date    2017.5.5
     */
    public function run()
    {
        $data = new UserData();
        $adapter = new UserAdapter();

        //验证身份证号码是否为空
        $idnoIsEmpty = $data->idnoIsEmpty();
        $idno = $data->getUserIdno($this->session->userid);
        if ($idnoIsEmpty === true && !empty($idno)) {
            return $this->Error(ErrorData::$USER_IDNO_REQUIRED);
        }

        //同盾查看是否匹配git
        $name = $this->request->input('data.name');
        $idno = $this->request->input('data.idno');
        $idnoCheck = $data->tongDunApi($name, $idno);
        if ($idnoCheck === false) {
            return $this->Error(ErrorData::$USER_IDNO_ERROR);
        }

        $paypwd = $this->request->input('paypwd');
        $res = $data->savePayPwd($this->session->userid, $paypwd);
        if ($res['res'] === false) {
            return $this->Error($res['code']);
        }

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
        return $this->Success();
    }
}
