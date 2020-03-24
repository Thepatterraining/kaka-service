<?php

namespace App\Http\Controllers\News;

use App\Data\Sys\NewsData;
use App\Http\Adapter\Sys\NewsAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetScrollNews extends Controller
{
    /**
     * @api {post} token/sys/getscrollnews 首页公告滚动
     * @apiName getscrollnews
     * @apiGroup News
     * @apiVersion 0.0.1
     *
     * @apiParam {string} accessToken token
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      accessToken : 'token'
     *  }
     *
     * @apiSuccess {number} code 状态码 = 0 成功
     * @apiSuccess {string} msg 调用成功
     * @apiSuccess {datetime} datetime 调用时间
     * @apiSuccess {object} data 返回数据
     *
     * @apiSuccessExample {json} Success-Response:
     *  {
     *      code : 0,
     *      msg  : '调用成功',
     *      datetime : '2017-05-17 14:15:59',
     *      data : {
     *              no        : 'NC2017110316035826218', //'编号'
     *              title     : '标题', //'标题'
     *      }   
     *  }
     */
    protected function run()
    {
        $request = $this->request->all();
        $data = new NewsData();
        $adapter = new NewsAdapter();

        $news = $data->getHomeScrollNews();
        $newsArray = ['no','title'];
        $res = [];
        foreach ($news as $new) {
            $arr = $adapter->getDataContract($new, $newsArray);
            $res[] = $arr;
        }

        $this->success($res);
    }
}
