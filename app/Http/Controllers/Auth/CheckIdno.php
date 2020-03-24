<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Sys\ErrorData;
use App\Data\User\UserData;

class CheckIdno extends Controller
{

    protected $validateArray=[
        "name"=>"required",
        "idno"=>"required|idno",
    ];

    protected $validateMsg = [
        "name.required"=>"请输入姓名!",
        "idno.required"=>"请输入身份证号!",
    ];

    /**
     * 判断身份证号是否匹配
     *
     * @param   $name 姓名
     * @param   $idon 身份证号
     * @author  zhoutao
     * @version 0.1
     * @date    2017.5.2
     */
    public function run()
    {
        $request = $this->request->all();
        $name = $request['name'];
        $idno = $request['idno'];

        //查询实名是否正确
        $data = new UserData();
        $idnoCheck = $data->tongDunApi($name, $idno);
        if ($idnoCheck === false) {
            return $this->Error(ErrorData::$USER_IDNO_ERROR);
        }

        return $this->Success();
    }
}
