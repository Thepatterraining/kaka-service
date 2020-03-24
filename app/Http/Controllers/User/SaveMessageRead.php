<?php

namespace App\Http\Controllers\User;

use App\Data\Sys\MessageData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaveMessageRead extends Controller
{
    protected $validateArray=[
        "id"=>"required",
    ];

    protected $validateMsg = [
        "id.required"=>"请输入消息id",
    ];

    /**
     * 修改消息状态为已读
     *
     * @param   $id 消息id
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.2
     */
    public function run()
    {
        $id = $this->request->input('id');
        $data = new MessageData();
        $data->saveReadStatus($id);
    }
}
