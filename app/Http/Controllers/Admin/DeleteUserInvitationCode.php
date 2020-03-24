<?php

namespace App\Http\Controllers\Admin;

use App\Data\Activity\InvitationCodeData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteUserInvitationCode extends Controller
{
    protected $validateArray=[
        "code"=>"required",
    ];

    protected $validateMsg = [
        "code.required"=>"请输入用户邀请码",
    ];

    /**
     * 删除用户邀请码
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
        //查询有没有这个用户邀请码
        $info = $data->getByNo($code);
        if ($info == null) {
            return $this->Error(801010);
        }

        //删除
        $data->delCode($code);

        return $this->Success('删除成功');
    }
}
