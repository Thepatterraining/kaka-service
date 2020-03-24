<?php

namespace App\Http\Controllers\User;

use App\Data\Sys\MessageData;
use App\Http\Adapter\Sys\MessageAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetMessageList extends Controller
{
    protected $validateArray=[
        "pageIndex"=>"required|integer",
        "pageSize"=>"required|integer",
    ];

    protected $validateMsg = [
        "pageIndex.required"=>"请输入页码",
        "pageSize.required"=>"请输入每页数量",
        "pageIndex.integer"=>"页码必须是整数",
        "pageSize.integer"=>"每页数量必须是整数",
    ];

    /**
     * 查询消息列表
     *
     * @param   $pageIndex
     * @param   $pageSize
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.2
     */
    public function run()
    {
        $request = $this->request->all();
        $userId = $this->session->userid;
        $pageIndex = $request['pageIndex'];
        $pageSize = $request['pageSize'];
        $data = new MessageData();
        $adapter = new MessageAdapter();
        $request['filters']['to'] = $userId;
        $filers = $adapter->getFilers($request);
        $item = $data->query($filers, $pageSize, $pageIndex);
        $res = [];
        foreach ($item['items'] as $val) {
            //去字典表查询类型和状态
            $arr = $adapter->getDataContract($val);
            //把消息的状态改为推送
            $time = $data->saveReadStatus('MSG01', $arr['no']);
            if ($time != null) {
                $arr['readtime'] = $time;
            }
            $res[] = $arr;
        }

        $item['items'] = $res;
        $this->Success($item);
    }
}
