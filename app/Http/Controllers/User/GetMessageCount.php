<?php

namespace App\Http\Controllers\User;

use App\Data\Sys\MessageData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetMessageCount extends Controller
{
    protected $validateArray=[
        "status"=>"required|dic:message_status",
    ];

    protected $validateMsg = [
        "status.required"=>"请输状态",
    ];

    /**
     * 查询用户未读数量
     *
     * @param   $status 状态
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.4
     */
    public function run()
    {
        $status = $this->request->input('status');

        $data = new MessageData();
        $res = $data->getMsgCount($status, null);
        $this->Success($res);
    }
}
