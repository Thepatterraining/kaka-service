<?php

namespace App\Http\Controllers\User;

use App\Data\Sys\MessageData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteMessage extends Controller
{
    protected $validateArray=[
        "no"=>"required",
    ];

    protected $validateMsg = [
        "no.required"=>"请输入消息编号",
    ];

    /**
     * 删除消息
     *
     * @param   $id 消息id
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.2
     */
    public function run()
    {
        $no = $this->request->input('no');
        $data = new MessageData();
        $data->delMsg($no);
        $this->Success('删除成功！');
    }
}
