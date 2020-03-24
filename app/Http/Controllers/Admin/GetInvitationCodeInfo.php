<?php

namespace App\Http\Controllers\Admin;

use App\Data\Activity\InvitationCodeData;
use App\Http\Adapter\Activity\InvitationCodeAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetInvitationCodeInfo extends Controller
{
    protected $validateArray=[
        "code"=>"required",
    ];

    protected $validateMsg = [
        "code.required"=>"请输入用户类型",
    ];

    /**
     * 查询用户邀请码详细
     *
     * @param   $code 邀请码
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.12
     */
    public function run()
    {
        $request = $this->request->all();
        $code = $request['code'];

        $data = new InvitationCodeData();
        $adapter = new InvitationCodeAdapter();

        $info = $data->getByNo($code);
        if ($info == null) {
            return $this->Error(801010);
        }

        $res = [];
        $res = $adapter->getDataContract($info);

        $this->Success($res);
    }
}
