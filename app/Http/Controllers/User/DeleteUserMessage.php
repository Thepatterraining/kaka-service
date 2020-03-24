<?php

namespace App\Http\Controllers\User;

use App\Data\Sys\MessageData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteUserMessage extends Controller
{
    /**
     * 一键删除用户所有信息
     *
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.4
     */
    public function run()
    {
        $data = new MessageData();
        $data->delMessage();
        $this->Success('删除成功！');
    }
}
