<?php

namespace App\Http\Controllers\User;

use App\Data\Sys\NewsData;
use App\Http\Adapter\Sys\NewsAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetHomeNews extends Controller
{
    public function run()
    {
        //接收数据
        $request = $this->request->all();
        $data = new NewsData();
        $adapter = new NewsAdapter();
        $request['filters']['type'] = 'NEWS01';
        $where = $adapter->getFilers($request);
        $news01 = $data->find($where);
        $res['news01'] = [];
        if ($news01 != null) {
            $res['news01'] = $adapter->getDataContract($news01, ['no','title','intro','time']);
            $res['news01']['time'] = date('Y-m-d', strtotime($res['news01']['time']));
        }

        $request['filters']['type'] = 'NEWS02';
        $where = $adapter->getFilers($request);
        $news02 = $data->find($where);
        $res['news02'] = [];
        if ($news02 != null) {
            $res['news02'] = $adapter->getDataContract($news02, ['no','title','intro','time']);
            $res['news02']['time'] = date('Y-m-d', strtotime($res['news02']['time']));
        }

        $request['filters']['type'] = 'NEWS03';
        $where = $adapter->getFilers($request);
        $news03 = $data->find($where);
        $res['news03'] = [];
        if ($news03 != null) {
            $res['news03'] = $adapter->getDataContract($news03, ['no','title','intro','time']);
            $res['news03']['time'] = date('Y-m-d', strtotime($res['news03']['time']));
        }

        return $this->Success($res);
    }
}
