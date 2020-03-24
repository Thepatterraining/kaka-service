<?php

namespace App\Http\Controllers\Admin\Sys;

use App\Data\Sys\NewsData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteNews extends Controller
{
    protected $validateArray=[
        "no"=>"required",
    ];

    protected $validateMsg = [
        "no.required"=>"请输入公告单号",
    ];

    /**
     * 删除公告
     *
     * @param   $userType 用户类型
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.12
     */
    public function run()
    {
        $request = $this->request->all();
        $newsNo = $request['no'];

        $data = new NewsData;
        //查询
        $info = $data->deleteNews($newsNo);

        return $this->Success('删除成功');
    }
}
